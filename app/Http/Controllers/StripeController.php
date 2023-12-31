<?php

namespace App\Http\Controllers;

use App\Models\StripeAccount;
use App\Models\User;
use App\Models\Bill;


use Exception;
use Illuminate\Http\Request;
use Stripe\OAuth;
use Stripe\Stripe;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    
    private $stripe;
    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.api_keys.secret_key'));
        Stripe::setApiKey(config('stripe.api_keys.secret_key'));
    }

    public function CreateAccount(){
        $resul = $this->stripe->accounts->create([
            'type' => 'standard',
            'country' => 'US',
            // 'email' => 'jenny.rosen@example.com',
        ]);
        return response()->json($resul);
    }

    public function GetPublishableKey(){
        $key = config('stripe.api_keys.publishable_key');
        return response()->json($key);
    }

    public function CreateAccountLink( Request $request ){
        $accountId = $request['account_id'];

        $link = $this->stripe->accountLinks->create([
          'account' => $accountId,
          'refresh_url' => 'https://example.com/reauth',
          'return_url' => 'https://example.com/return',
          'type' => 'account_onboarding',
        ]);

        Log::Info($link );
        
        return response()->json($link);
    }

    public function connectToStripe(Request $request){
        $userId = $request['user']['id'];
        $account = $this->CreateAccount();
        $account_id = $account->getData()->id;
        StripeAccount::updateOrCreate(
            [
                'user_id'    => $userId,
            ],
            [
                'account_id' => $account_id
            ]

        );
        $myRequest = new Request();
        $myRequest->merge(['account_id' => $account_id]);
        $link = $this->CreateAccountLink($myRequest);
        return response()->json($link);
    }

    public function stripeAccountExist(Request $request){
        $userId = $request['user']['id'];
        $myUser = User::where('id', $userId)->with('stripeAccount')->first();
        return response()->json($myUser);  
    }

    public function checkOnboarding(Request $request){
        $accountID = $request['account_id'];
        $account = $this->stripe->accounts->retrieve(
          $accountID,
          []
        );
        return response()->json($account);  
    }

    public function createClient(){
        $stripeClientData = $this->stripe->customers->create([]);
        return response()->json($stripeClientData);
    }

    public function createClientForConnectedAccount(Request $request){
        // $connected_account_id = $request->stripe_account;
        $connected_account_id = 'acct_1OS2OgPQJmQihlBX';
        $stripeCustomerData = $this->stripe->customers->create(
            [
                'name'  => $request->customer_name,
                'email' => $request->customer_email,  // Replace with the customer's email
                // 'description' => 'Customer for connected account',
            ],
            [
                'stripe_account' => $connected_account_id
            ]
        );
        return response()->json($stripeCustomerData);
    }

    public function stripePaymentIntent(Request $request){
        $paymentID = $this->stripe->paymentIntents->create([
          'amount' => intval($request['bill_price']) * 100,    //Since stripe asumes the amounts in cents
          'currency' => 'usd',
          'automatic_payment_methods' => [
            'enabled' => true
            ],
        ]);
        return response()->json($paymentID);
    }

    public function stripePaymentIntentOnCustomer(Request $request){
        $paymentID = $this->stripe->paymentIntents->create([
            'customer' => $request['customer_id'],
            'setup_future_usage' => 'off_session',
            'amount' => intval($request['bill_price']) * 100,    //Since stripe asumes the amounts in cents
            'currency' => 'usd',
            'automatic_payment_methods' => [
               'enabled' => true
            ],
        ]);
        return response()->json($paymentID);
    }

    public function createAccountPaymentIntent(Request $request){
        $paymentID = $this->stripe->paymentIntents->create([
            'customer' => $request['customer_id'],
            'setup_future_usage' => 'off_session',
            'amount' => intval($request['bill_price']) * 100,    //Since stripe asumes the amounts in cents
            'currency' => 'usd',
            'automatic_payment_methods' => ['enabled' => true],
        ],
        ['stripe_account' => $request['stripe_account']]
        );
        return response()->json($paymentID);
    }

    public function stripeSavedPaymentIntentOnCustomer(Request $request){
        $paymentMethod = $this->getPaymentMethodFOrCustumer($request['customer_id']);
        $paymentID = $this->stripe->paymentIntents->create([
            'customer'                  => $request['customer_id'],
            'payment_method'            => $paymentMethod['data'][0]->id,
            'return_url'                => config('app.url'),
            'off_session'               => true,
            'confirm'                   => true,
            'amount'                    => intval($request['amount']) * 100,
            'currency'                  => 'usd',
            'automatic_payment_methods' => [
               'enabled' => true
            ],
        ]);
        return response()->json($paymentID);
    }

    private function getPaymentMethodForCustumer($customerId){
        $paymentMethod = $this->stripe->paymentMethods->all([
          'customer' => $customerId,
          'type' => 'card',
        ]);

        return $paymentMethod;
    }

    public function isPaymentConfirm($payment_ID){
        $resul = false;
        $paymentintent = $this->getPaymentIntent($payment_ID);
        $status = $paymentintent->status;
        if($status == "succeeded"){
            $resul = true;
        }
        return $resul;
    }

    public function getPaymentIntent($payment_ID){
        $paymentID = $payment_ID;

        $paymentIntentObj = $this->stripe->paymentIntents->retrieve(
          $paymentID,
          []
        );

        return $paymentIntentObj;
    }    
    public function getPrice(Request $request){
        $priceID = $request['price_id'];
        $price = $this->stripe->prices->retrieve(
          $priceID,
          []
        );
        return response()->json($price);
    }

    public function createCheckoutSession(Request $request)
    {
        $priceId = $request['priceId'];
        $userId  = $request['userId'];
        $planId  = $request['subsId'];

        // $session = \Stripe\Checkout\Session::create([
        //   'success_url' => config('app.url').'/subscriptions/thanks?session_id={CHECKOUT_SESSION_ID}&user_id='.$userId.'&plan_id='.$planId,
        //   'cancel_url' => 'https://example.com/canceled.html',
        //   'mode' => 'subscription',
        //   'line_items' => [[
        //     'price' => $priceId,
        //     // For metered billing, do not pass quantity
        //     'quantity' => 1,
        //   ]],
        // ]);

        $connetedAcc = 'acct_1OL1LwPBNm6pfq3b';

        $session = $this->stripe->checkout->sessions->create(
            [
            'mode' => 'payment',
            'line_items' => [
                [
                    'price' => $priceId,
                    'quantity' => 1,
                ],
            ],
            'payment_intent_data' => [
                'application_fee_amount' => 123
            ],
            'success_url' => 'https://example.com/success',
            'cancel_url' => 'https://example.com/cancel',
            ],
            [
                'stripe_account' => $connetedAcc
            ]
        );
        return response()->json($session);      
    }

    public function verifyCheckoutSession(Request $request){
        $sessionID = $request['session_id'];
        $userId    = $request['user_id'];
        $planId    = $request['plan_id'];

        $session = $this->stripe->checkout->sessions->retrieve($sessionID);
        // $customer = $stripe->customers->retrieve($session->customer);
        // return response()->json($session); 
        if ($session) {
            $this->assignPlan($userId , $planId );
             return response()->json(['message' => 'Success', 'session' => $session]);
        } else {
            return response()->json(['message' => 'Error']);
        }  
    }

    public function assignPlan($useID , $planID ){
        $user = User::find($useID);
        $user->subscription()->associate($planID);
        $user->save();
    }
}

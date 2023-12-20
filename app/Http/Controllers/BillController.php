<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill; 
use App\Models\Charge; 

use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Log;

class BillController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function createBillForReservation( Request $request)
    {
        // $bill = Bill::create($request->all());

        // Validate the request...
        
        $bill = new Bill;

        $bill->reservation_id = $request->reservation_id;
        
        $bill->price = $request->price;
        
        $bill->save();

        $stripeObj = new StripeController;

        $customer =  $stripeObj->createClient();

        $myRequest = new Request();
        $myRequest->merge([
            'customer_id' => $customer->original->id,
            'bill_price'  => $request->charge_now_amount,
        ]);

        $paymentIntent = $stripeObj->stripePaymentIntentOnCustomer($myRequest);

        Log::info($paymentIntent->original);
        
        // $this->createFirstChargeForBill($request->charge_now_amount , $paymentIntent , $bill->id);
        // $this->createSecondChargeForBill($bill->id , $request->charge_later_amount , $request->charge_later_date);
        // $this->createHoldChargeForBill();

        //Create the retur object with 
        return response()->json($paymentIntent->original, 201);
    }

    private function createFirstChargeForBill($amount, $paymentId, $billId ){

        $charge              = new Charge;
        $charge->amount      = $amount;
        $charge->payment_id  = null;  //create payment intent here
        $charge->bill_id     = $billId;
        $charge->save();


    }
}

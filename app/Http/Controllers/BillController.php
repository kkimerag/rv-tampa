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
        $stripeObj = new StripeController;
        $customer =  $stripeObj->createClient();


        $bill = new Bill;
        $bill->reservation_id = $request->reservation_id;   
        $bill->customer_id    = $customer->original->id;
        $bill->price          = $request->price;        
        $bill->save();

        $myRequest = new Request();
        $myRequest->merge([
            'customer_id' => $customer->original->id,
            'bill_price'  => $request->charge_now_amount,
        ]);

        $paymentIntent = $stripeObj->stripePaymentIntentOnCustomer($myRequest);

        // Log::info($paymentIntent->original);
        
        $this->createFirstChargeForBill($request->charge_now_amount , $request->charge_now_date, $paymentIntent->original->id , $bill->id);
        $this->createSecondChargeForBill($request->charge_later_amount , $request->charge_later_date, $paymentIntent->original->id , $bill->id);
        // $this->createHoldChargeForBill();

        //Create the retur object with 
        return response()->json($paymentIntent->original, 201);
    }

    private function createFirstChargeForBill($amount, $dueDate, $paymentId, $billId ){
        $charge              = new Charge;
        $charge->amount      = $amount;
        $charge->payment_id  = $paymentId;  //create payment intent here
        $charge->due_date    = $dueDate;
        $charge->bill_id     = $billId;
        $charge->save();
    }

    private function createSecondChargeForBill($amount, $dueDate, $paymentId, $billId ){
        $charge              = new Charge;
        $charge->amount      = $amount;
        $charge->payment_id  = null;  //create payment intent here
        $charge->due_date    = $dueDate;
        $charge->bill_id     = $billId;
        $charge->save();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Reservation; 
use App\Models\Charge; 

use Illuminate\Http\Request;

use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function CreateReservation(Request $request){

        $reservation = Reservation::create($request->all());

        return response()->json($reservation, 201);
    }

    public function getPendings(){
        $reservations = Reservation::whereHas('bill.charges' , function($query){
            $query->whereNull('payment_id');
        })->with('bill.charges')->get();
        return $reservations;
    }

    public function collectFinalCharges(Request $request){
        $stripeObj     = new StripeController;
        $customerId    = $request->customer_id;
        $myRequest = new Request();
        $myRequest->merge([
            'customer_id' => $request->customer_id,
            'amount'      => $request->amount,     //it shouyld come from back-end
        ]);
        $paymentIntent =   json_decode( $stripeObj->stripeSavedPaymentIntentOnCustomer($myRequest)->getContent() ,true );

        $paymentIntentId     = $paymentIntent['id'];
        $paymentIntentStatus = $paymentIntent['status'];

        if($paymentIntentStatus == 'succeeded'){
            $charge = Charge::find($request->charge_id);
            $charge->payment_id = $paymentIntentId;
            $charge->save();
        }
        return $paymentIntent;
    }
}

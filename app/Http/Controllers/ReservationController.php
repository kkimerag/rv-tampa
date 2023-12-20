<?php

namespace App\Http\Controllers;

use App\Models\Reservation; 

use Illuminate\Http\Request;

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
}

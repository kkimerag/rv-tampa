<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill; 

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
        
        $bill->price = $request->price;
        
        $bill->save();
        

        return response()->json($bill, 201);
    }

    public function createChargesForBill(){
        
    }
}

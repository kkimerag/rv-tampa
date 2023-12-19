<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function createBillForReservation( Request $request)
    {
        $bill = Bill::create($request->all());

        return response()->json($reservation, 201);
    }
}

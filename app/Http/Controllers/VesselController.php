<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Vessel;

class VesselController extends Controller
{
    public function getVessels(){
        $vessels = Vessel::with('type')->with('location')->with('rate')->get();
        return response()->json($vessels);
    }
}

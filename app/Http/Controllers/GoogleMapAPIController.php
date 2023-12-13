<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleMapAPIController extends Controller
{
    public function GetPlaceId(Request $request){
        $response = \GoogleMaps::load('geocoding')
                ->setParam ([
                    'address' =>'santa cruz',
                    'components' => [
                        'administrative_area'  => 'TX',
                        'country'              => 'US',
                      ]
                ])
                ->get();
        $responseJSON = json_decode($response);
        $placeId = $responseJSON->results[0]->place_id;
        dd($placeId);
        return response()->json($placeId);  
    }

    public function autocomplete(Request $request){
        $response = \GoogleMaps::load('placeautocomplete')
                ->setParam ([
                    'input' => '6108 B'
                ])
                ->get();
        $responseJSON = json_decode($response); 
        $predictions = $responseJSON->predictions;
        dd($predictions);
        return response()->json($predictions);
    }
}

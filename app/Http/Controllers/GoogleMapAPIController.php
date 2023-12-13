<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleMapAPIController extends Controller
{
    public function GetPlaceId(Request $request){
        $address = $request->location['street_address'];
        $administrative_area = $request->location['state']['name'];

        $response = \GoogleMaps::load('geocoding')
                ->setParam ([
                    'address' =>$address,
                    'components' => [
                        'administrative_area'  => $administrative_area,
                        'country'              => 'US',
                      ]
                ])
                ->get();
        $responseJSON = json_decode($response);
        $placeId = $responseJSON->results[0]->place_id;

        return $placeId;  
    }

    public function autocomplete(Request $request){
        $input = $request->input;
        $response = \GoogleMaps::load('placeautocomplete')
                ->setParam ([
                    'input' => $input,
                ])
                ->get();
        $responseJSON = json_decode($response); 
        $predictions = $responseJSON->predictions;
        return response()->json($predictions);
    }

    public function getDistance(Request $request){
        $originLocation = $request->origin_address;
        $customRequest = new Request();
        $location = $originLocation;
        $customRequest->merge(['location' => $location]);

        $originPlaceId      = $this->GetPlaceId($customRequest);
        $destinationPlaceId = $request->destination_place_id;


        $response = \GoogleMaps::load('distancematrix')
                    ->setParam([
                        'origins'          => 'place_id:'.$originPlaceId,
                        'destinations'     => 'place_id:'.$destinationPlaceId,
                        'units'            => 'imperial'
                    ])
                   ->get();
        return $response;
    }

}

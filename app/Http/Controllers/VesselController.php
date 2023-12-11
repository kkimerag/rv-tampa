<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BucketController;
use Illuminate\Support\Facades\Log;

use App\Models\Vessel;

class VesselController extends Controller
{
    public function getVessels(){
        $vessels = Vessel::with('type')->with('location.state')->with('rate')->with('vesselImages')->get();
        $bucketController = new BucketController;
        foreach($vessels as $vessel){
            $folder  = $vessel->img_folder;
            $vesselImages = $vessel->vesselImages;

            foreach ($vesselImages as &$image) {
                $request2 = new Request();
                $baseFileName = explode(".", $image['image_path'])[0];
                $request2->merge([
                    'inBucketURL' => $folder.'/'.$baseFileName.'.jpg',
                    'thumbnail'   => false,
                ]);
                $image['thumbnailUrl'] = $bucketController->getPresignedURL($request2);
            }
        } 
        return response()->json($vessels);
    }
}

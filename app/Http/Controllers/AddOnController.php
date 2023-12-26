<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

use App\Models\AddOn;

class AddOnController extends Controller
{
    public function getAddons(Request $request)
    {
        $userId = $request->user_id;
        Log::Info($userId);
        $addons = AddOn::where('user_id' , $userId)->get();
        return response()->json($addons);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\DeviceFCM;
use Illuminate\Http\Request;

class FcmController extends Controller
{
    public function storeNewDevice(Request $request){
        $device = $request->device;
        $username = $request->username;
        $token = $request->token;

        // Check if a record with the same device and username exists
        $existingData = DeviceFCM::where('device', $device)
            ->where('username', $username)
            ->first();

        if ($existingData) {
            // If the record exists, update the token
            $existingData->token = $token;
            $existingData->save();
        } else {
            // If the record doesn't exist, create a new one
            $data = new DeviceFCM();
            $data->device = $device;
            $data->username = $username;
            $data->token = $token;
            $data->save();
        }
        return response()->json(['message' => 'Device data stored successfully']);
    }

    public function getFcm(Request $request){
        return DeviceFCM::all();
    }
}

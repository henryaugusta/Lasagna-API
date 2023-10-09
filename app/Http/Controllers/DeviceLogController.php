<?php

namespace App\Http\Controllers;

use App\Models\DeviceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeviceLogController extends Controller
{
    public function store(Request $request){
        $eventName = $request->event;
        $device = $request->device;
        $origin = $request->origin;
        $data = new DeviceLog();
        $data->event = $eventName;
        $data->device = $device;
//        $data->origin = $origin;
        $data->save();
    }

    public function checkStatus(){
        $token = 'oMps6Fj2XqUbsaLs1pCYbr6hl0j59I6x';
        $endpoints = ['v4', 'v5', 'v6', 'v7', 'v8'];

        $results = collect($endpoints)->map(function ($endpoint) use ($token) {
            $response = Http::get("https://blynk.cloud/external/api/get?token={$token}&{$endpoint}");
            $status = $response->body(); // Assuming 1 or 0 is returned as a string.

            return [
                'device' => $endpoint,
                'status' => $status,
                'is_on' => $status === '1',
            ];
        });

        $emergencyCount = $results->filter(function ($result) {
            return $result['status'] === '1';
        })->count();

        if ($emergencyCount >= 3) {
            $status = 'EMERGENCY';
        } else {
            $status = 'OKAY';
        }
        return response()->json(['status' => $status, 'devices' => $results]);

    }
}

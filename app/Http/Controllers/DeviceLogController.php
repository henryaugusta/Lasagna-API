<?php

namespace App\Http\Controllers;

use App\Models\DeviceLog;
use Illuminate\Http\Request;

class DeviceLogController extends Controller
{
    public function store(Request $request){
        $eventName = $request->event;
        $device = $request->device;
        $origin = $request->origin;

        $data = new DeviceLog();

        $data->event = $eventName;
        $data->device = $device;
        $data->origin = $origin;

    }
}

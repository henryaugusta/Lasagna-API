<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\DeviceFCM;
use Illuminate\Http\Request;

class FcmController extends Controller
{
    public function storeNewDevice(Request $request)
    {
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

    public function getFcm(Request $request)
    {
        $datas = DeviceFCM::distinct('token')->get();

        $results = [];

        foreach ($datas as $data) {
            $curl = curl_init();
            $token = $data->token;

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                "notification" :{
                    "title": "EMERGENCY",
                    "body": "Ada Orang Jatuh di Kamar Mandi, Segera Berikan Pertolongan",
                    "click_action" :"FLUTTER_NOTIFICATION_CLICK",
                    "sound": "manydocwaiting.caf",
                    "badge" :4,
                    "content_available" : true,
                    "mutable_content":true
                },
                "data":{
                    "name":"Wahyudi Atkinson Rohadi",
                    "age":25
                },
                "to":"' . $token . '"
            }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: key=AAAA9dJJOgM:APA91bEuhXVL6lgh7yPfknMYMSriWSv2LcDdSoMQakeZe3NiqfweYMHAPgyDifC7cHWUFvJL3ZvHeDCZ92wiSEHJyRr1fj3Su4o4X4k5bhubXfogqBQcguGF1ZHz3fqpaFM2Lsp729Q2'
                ),
            ));

            $response = curl_exec($curl);

            // Assuming you want to collect the response for each request
            $results[] = json_decode($response, true);

            curl_close($curl);
        }

        return response()->json(['results' => $results]);
    }
}

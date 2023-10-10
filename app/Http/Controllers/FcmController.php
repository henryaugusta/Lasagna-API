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
        $datas = DeviceFCM::all();
        $results = [];

        // Initialize Guzzle client
        $client = new Client();

        foreach ($datas as $data) {
            $token = $data->token;

            // Define the FCM message payload
            $payload = [
                'token' => $token,
                'notification' => [
                    'title' => 'Tes Push Notification',
                    'body' => 'Haiyanto jual 2454 lot',
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    'sound' => 'manydocwaiting.caf',
                    'badge' => 4,
                    'content_available' => true,
                    'mutable_content' => true,
                ],
                'data' => [
                    'name' => 'Wahyudi Atkinson Rohadi',
                    'age' => 25,
                ],
            ];

            try {
                // Send the FCM message using Guzzle
                $response = $client->post('https://fcm.googleapis.com/fcm/send', [
                    'headers' => [
                        'Authorization' => 'key=AAAA9dJJOgM:APA91bEuhXVL6lgh7yPfknMYMSriWSv2LcDdSoMQakeZe3NiqfweYMHAPgyDifC7cHWUFvJL3ZvHeDCZ92wiSEHJyRr1fj3Su4o4X4k5bhubXfogqBQcguGF1ZHz3fqpaFM2Lsp729Q2',
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $payload,
                ]);

                // Handle the response as needed
                $statusCode = $response->getStatusCode();
                $results[] = ['token' => $token, 'status' => 'success', 'statusCode' => $statusCode];
            } catch (\Exception $e) {
                // Handle any exceptions that occur during the Guzzle request
                // Log the error or take appropriate action
                $results[] = ['token' => $token, 'status' => 'error', 'message' => $e->getMessage()];
            }
        }

        return response()->json(['results' => $results]);
    }
}

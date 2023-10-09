<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;


class CIOTDeviceController extends Controller
{

    public function makeApiRequest(Request $request)
    {

    }


    public function turnOnLamp(Request $request){
        $client = new Client();
        $url = 'https://blynk.cloud/external/api/update?token=oMps6Fj2XqUbsaLs1pCYbr6hl0j59I6x&V1=1';
        try {
            // Make a GET request
            $response = $client->get($url);

            // Get the response body as a string
            $body = $response->getBody()->getContents();

            // Return the response or do something else with it
            return response()->json(['data' => $body]);
        } catch (\Exception $e) {
            // Handle exceptions (e.g., Guzzle exceptions, connection errors, etc.)
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function turnOffLamp(Request $request){
        $client = new Client();
        $url = 'https://blynk.cloud/external/api/update?token=oMps6Fj2XqUbsaLs1pCYbr6hl0j59I6x&V1=0';
        try {
            // Make a GET request
            $response = $client->get($url);

            // Get the response body as a string
            $body = $response->getBody()->getContents();

            // Return the response or do something else with it
            return response()->json(['data' => $body]);
        } catch (\Exception $e) {
            // Handle exceptions (e.g., Guzzle exceptions, connection errors, etc.)
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function openDoor(Request $request){
        $client = new Client();
        $url = 'https://blynk.cloud/external/api/update?token=oMps6Fj2XqUbsaLs1pCYbr6hl0j59I6x&V9=1';
        try {
            // Make a GET request
            $response = $client->get($url);

            // Get the response body as a string
            $body = $response->getBody()->getContents();

            // Return the response or do something else with it
            return response()->json(['data' => $body]);
        } catch (\Exception $e) {
            // Handle exceptions (e.g., Guzzle exceptions, connection errors, etc.)
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function closeDoor(Request $request){
        $client = new Client();
        $url = 'https://blynk.cloud/external/api/update?token=oMps6Fj2XqUbsaLs1pCYbr6hl0j59I6x&V9=0';
        try {
            // Make a GET request
            $response = $client->get($url);

            // Get the response body as a string
            $body = $response->getBody()->getContents();

            // Return the response or do something else with it
            return response()->json(['data' => $body]);
        } catch (\Exception $e) {
            // Handle exceptions (e.g., Guzzle exceptions, connection errors, etc.)
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DistanceMatrixController extends Controller
{
    // public function fetchDistanceMatrix(Request $request)
    // {
    //     $origin1 = "72 Padilla St, Padilla Gomez, San Carlos City, Pangasinan";
    //     $destination1 = "Dagupan";
    //     $origin = urlencode($origin1);
    //     $destination = urlencode($destination1);
    //     $apiKey = env('GOOGLE_MAPS_API_KEY');

    //     $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$origin}&destinations={$destination}&units=matrics&key={$apiKey}";

    //     $response = Http::get($url);

    //     dd($response->json());

    //     return $response->json();
    // }

    public function fetchDistanceMatrixCopy(
        $origin = "123 Main St, Anytown, USA",
        $destination = "456 Elm St, Anycity, USA"
    ) {
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$origin}&destinations={$destination}&units=metrics&key={$apiKey}";

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                return $response->json();
            } else {
                return response()->json(['error' => 'Failed to fetch distance matrix'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching distance matrix'], 500);
        }
    }

    public function fetchDistanceMatrix(
        $origin = "123 Main St, Anytown, USA",
        $destination = "456 Elm St, Anycity, USA"
    ) {
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$origin}&destinations={$destination}&units=metrics&key={$apiKey}";

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();

                // Check if the response contains the required fields
                if (isset($data['rows'][0]['elements'][0]['distance']['text'])) {
                    // Extract and return the distance text
                    return $data['rows'][0]['elements'][0]['distance']['text'];
                } else {
                    return response()->json(['error' => 'Distance text not found in response'], 500);
                }
            } else {
                return response()->json(['error' => 'Failed to fetch distance matrix'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching distance matrix'], 500);
        }
    }

}

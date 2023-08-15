<?php

namespace App\Http\Controllers\Traits;


use GuzzleHttp\Client;


trait RefreshClientProfile
{
    public function refreshClientProfile($clientId){
        $client = new Client();

        $url = "http://localhost:8000/api/clients/{$clientId}/profile/refresh";

        $response = $client->request('GET', $url, [
            'headers' => [
                'api_key' => 'Po77NiLBrg',
            ],
        ]);
        $statusCode = $response->getStatusCode();

        if ($statusCode === 200) {
            return true;
        } else {
            return false;
        }
    }


}

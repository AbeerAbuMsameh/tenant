<?php

namespace App\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait apiTrait
{
    public function apiResponse($data, $status, $msg)
    {
        return response()->json([
            'status' => $status,
            'response_message' => $msg,
            'data' => $data,
        ], 200);
    }


}

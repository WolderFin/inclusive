<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\License;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function infoKey($key)
    {
        $license = License::with('devices')->where('key', $key)->first();

        if (!$license) {
            return response()->json(['message' => 'License not found'], 404);
        }

        return response()->json($license);
    }
    public function infouuid($uuid)
    {
        $license = Device::with('license')->where('uuid', $uuid)->first();

        if (!$license) {
            return response()->json(['message' => 'License not found'], 404);
        }

        return response()->json($license);
    }

}

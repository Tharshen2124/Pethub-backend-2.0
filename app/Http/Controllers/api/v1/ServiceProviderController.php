<?php

namespace App\Http\Controllers\api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceProviderController extends Controller
{
    public function get_healthcare_facilties() 
    {
        $healthcare_facilities = User::where('service_type', 'healthcare')->get();
        
        return response()->json([
            'healthcare_facilities' => $healthcare_facilities
        ]);
    }

    public function get_grooming_facilities()
    {
        $grooming = User::where('service_type', 'grooming')->get();
        
        return response()->json([
            'grooming' => $grooming
        ]);
    }

    public function moreInfo(string $spid) {
        $sp = User::find($spid);

        if($sp) {
            return response()->json([
                'service_provider' => $sp
            ]);
        } else {
            return response()->json([
                'message' => 'Service provider not found',
            ], 404);
        }
    }
}

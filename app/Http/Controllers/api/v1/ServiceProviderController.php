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

    public function get_boarders()
    {
        $boarders = User::where('service_type', 'boarder')->get();
        
        return response()->json([
            'boarders' => $boarders
        ]);
    }
}
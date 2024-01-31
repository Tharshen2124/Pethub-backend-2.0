<?php

namespace App\Http\Controllers\api\v1;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;

class AppointmentController extends Controller
{
    //Store a newly made appointment
    public function store(StoreAppointmentRequest $request)
    {
        $user = auth('sanctum')->user();
        if($user->permission_level === '1') {
            $value = $request->validated();

            Appointment::create([
                'user_id' => $value['user_id'],
                'pet_id' => $value['pet_id'],
                'pet_service_provider_ref' => $value['pet_service_provider_ref'],
                'appointment_type' => $value['appointment_type'],
                'date' => $value['date'],
                'time' => $value['time'],
                'important_details' => $value['important_details'],
                'issue_description' => $value['issue_description'],
                'appointment_status' => 'pending'
            ]);

            return response()->json([
                'message' => 'Successfully made an appointment!',
            ], 201);
        } else {
            return response()->json([
                'error' => 'Unauthorised request'
            ]);
        }
        
    }

    // Display all the appointments made by a user
    public function index()
    {
        $user = auth('sanctum')->user();
        
        if($user->permission_level === "1") 
        {
            $appointments = $user->appointments()->get() ?? null;

            return response()->json([
                'appointment' => $appointments
            ]);

        } else {
            return response()->json([
                'error' => 'Unauthorised request',
            ], 401);
        }
    }

    // Display the specified appointments to a user.
    public function show(string $aptId)
    {
        $user = auth('sanctum')->user();
        
        if($user->permission_level === "1") 
        {
            $appointment = Appointment::with('user', 'pet')->find($aptId);

            if($appointment) {
                return response()->json([
                    'appointment' => $appointment
                ]);
            } else {
                return response()->json([
                    'error' => 'Appointment not found',
                ], 404);
            }
        } else {
            return response()->json([
                'error' => 'Unauthorised request'
            ], 401);
        }
    }
    
    /**
     * Below are routes for service provider ONLY.
     */

    // Display all the appointments made to a specified service provider
    public function sp_index(string $spref) 
    {
        $user = User::find($spref);

        if($user->permission_level === '2') {
            $appointments = Appointment::where('pet_service_provider_ref', $spref)->get() ?? null;

            if($appointments) {
                return response()->json([
                    'appointments' => $appointments
                ]);
            } else {
                return response()->json([
                    'error' => 'Appointment not found'
                ], 404);        
            }
        } else {
            return response()->json([
                'error' => 'Unauthorised request'
            ], 401);
        }
    }

    // Display the specified appointments made to a specified service provider
    public function sp_show(string $spref, string $aptId)
    {
        $user = User::find($spref);

        if($user->permission_level === '2') {
            $appointment = Appointment::find($aptId);

            if($appointment) {
                return response()->json([
                    'appointment' => $appointment
                ]);
            } else {
                return response()->json([
                    'error' => 'Appointment not found'
                ], 404);        
            }
        } else {
            return response()->json([
                'error' => 'Unauthorised request'
            ], 401); 
        }
    }
    
    // Update the specified resource in storage.
    public function update(Request $request,string $spref, string $aptId)
    {
        $user = User::find($spref);

        if($user->permission_level === '2') {
            $appointment = Appointment::find($aptId);
            if($appointment) {
                $validated =$request->validate([
                    'status' => [Rule::in(['approved', 'rejected']), 'required']
                ]);
    
                $appointment->update([
                    'status' => $validated['status']
                ]);
    
                return response()->json([
                    'message' => "Succesfully updated status of appointment"
                ]);
            } else {
                return response()->json([
                    'error' => 'Appointment not found'
                ], 404); 
            }
        } else {
            return response()->json([
                'error' => 'Unauthorised request'
            ], 401); 
        }
    }
}

<?php

namespace App\Http\Controllers\api\v1;

use App\Models\User;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    //register new user
    public function register(Request $request)
    {
        $existingUser = User::where('email', $request->email)->first();
        
        if($existingUser && $existingUser->user_status !== 'rejected') {
            return response()->json([
                'message' => "Unauthorized request, this email has been used already",
            ], 403);
        }
        if ($existingUser && $existingUser->user_status === 'rejected') {
            return response()->json([
                'message' => "Unauthorized request, this email has been banned",
            ], 403);
        }

        $validated = $request->validate([
            'full_name' => 'required',
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', Password::defaults(), 'confirmed'],
            'permission_level' => 'required',
            'contact_number' => ['required', 'regex:/^0[0-9]{9,10}$/'],
            'description' => 'required',
            'image' => 'image',
        ]);

        if(gettype($validated['permission_level'] === "string")) 
        {
            $permission_level = intval($validated['permission_level']);
        } else {
            $permission_level = $validated['permission_level'];
        }

        $password = Hash::make($validated['password']); // register for regular user
        
        if($request->hasFile('image'))
        {
            $profile = $request->file('image')->store('public/profile');
            $img = basename($profile);
            $linkToImage = asset('storage/profile/'.$img);
        }

        if($permission_level === 1) 
        {
            $user = User::create([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => $password,
                'permission_level' => $permission_level,
                'contact_number' => $validated['contact_number'],
                'description' => $validated['description'],
                'image' =>  $linkToImage,
                'user_status' => 'approved'
            ]);
        }

        elseif($permission_level === 2) // register for service provider
        {
            $SP_validated = $request->validate([
                'image' => 'required | image',
                'deposit_value' => 'required',
                'service_type' => 'required', Rule::in(['grooming', 'healthcare']),  
                'opening_hour' => 'required',
                'closing_hour' => 'required',
                'bank_name' => 'required',
                'beneficiary_acc_number' => 'required',
                'beneficiary_name' => 'required',
                'qr_code_image' => 'required | image',
                'sssm_certificate' => 'required | file',
            ]);

            if($request->hasFile('sssm_certificate') && $request->hasFile('qr_code_image'))
            {
                $qr_code_image = $request->file('qr_code_image')->store('public/qr_code');
                $img2 = basename($qr_code_image);
                $linkToQR = asset('storage/qr_code/'.$img2);
                
                $sssm_certificate = $request->file('sssm_certificate')->store('public/certs');
                $img3 = basename($sssm_certificate);
                $linkToCert = asset('storage/certs/'.$img3);
            }

            $user = User::create([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => $password,
                'permission_level' => $permission_level,
                'image' => $linkToImage,
                'contact_number' => $validated['contact_number'],
                'description' => $validated['description'],
                'deposit_value' => $SP_validated['deposit_value'],
                'service_type' => $SP_validated['service_type'],
                'opening_hour' => $SP_validated['opening_hour'],
                'closing_hour' => $SP_validated['closing_hour'],
                'bank_name' => $SP_validated['bank_name'],
                'beneficiary_acc_number' => $SP_validated['beneficiary_acc_number'],
                'beneficiary_name' => $SP_validated['beneficiary_name'],
                'qr_code_image' => $linkToQR,
                'user_status' => 'pending'
            ]);

            Certificate::create([
                'user_id' => $user->user_id,
                'certificate_upload' => $linkToCert,
                'certificate_service_type' => $SP_validated['service_type']
            ]);
        }

        Auth::login($user);

        $token = $request->user()->createToken('userToken')->plainTextToken;

        Log::debug("mom");

        return response()->json([
            'message' => "Successfully registered",
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    // login user
    public function login(LoginUserRequest $request)
    {
        $request->validated();

        $auth = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        $user_status = $request->user()->user_status;
        if($auth) 
        {
            if($user_status === 'rejected') {
                return response()->json([
                    'error' => "Unauthorised request"
                ], 403);
            } else {
                $token = $request->user()->createToken('userToken')->plainTextToken;
                return response()->json([
                    'message' => 'Success!',
                    'token' => $token,
                    'user' => $request->user()
                ], 200);
            }
            
        } else {
            $return =  [
                'message' => 'Error',
                'user' => null,
                'token' => null
            ];

            return response($return, 404);
        }
    }

    public function registerServiceProvider(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required',
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', Password::defaults(), 'confirmed'],
            'permission_level' => 'required',
            'contact_number' => ['required', 'regex:/^0[0-9]{9,10}$/'],
            'description' => 'required',
            'image' => 'required | image',
            'deposit_value' => 'required',
            'service_type' => 'required', Rule::in(['grooming', 'healthcare']),  
            'opening_hour' => 'required',
            'closing_hour' => 'required',
            'facility_location' => 'required',
            'bank_name' => 'required',
            'beneficiary_acc_number' => 'required',
            'beneficiary_name' => 'required',
            'qr_code_image' => 'required | image',
            'sssm_certificate' => 'required | file',
        ]);

        $password = Hash::make($validated['password']); // register for regular user
        
        if($request->hasFile('image'))
        {
            $profile = $request->file('image')->store('public/profile');
            $img = basename($profile);
            $linkToImage = asset('storage/profile/'.$img);
        }

        if($request->hasFile('sssm_certificate') && $request->hasFile('qr_code_image'))
        {
            $qr_code_image = $request->file('qr_code_image')->store('public/qr_code');
            $img2 = basename($qr_code_image);
            $linkToQR = asset('storage/qr_code/'.$img2);
            
            $sssm_certificate = $request->file('sssm_certificate')->store('public/certs');
            $img3 = basename($sssm_certificate);
            $linkToCert = asset('storage/certs/'.$img3);
        }

        $user = User::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => $password,
            'permission_level' => $validated['permission_level'],
            'image' => $linkToImage,
            'contact_number' => $validated['contact_number'],
            'description' => $validated['description'],
            'deposit_value' => $validated['deposit_value'],
            'service_type' => $validated['service_type'],
            'opening_hour' => $validated['opening_hour'],
            'closing_hour' => $validated['closing_hour'],
            'facility_location' => $validated['facility_location'],
            'bank_name' => $validated['bank_name'],
            'beneficiary_acc_number' => $validated['beneficiary_acc_number'],
            'beneficiary_name' => $validated['beneficiary_name'],
            'qr_code_image' => $linkToQR,
            'user_status' => 'pending'
        ]);

        Certificate::create([
            'user_id' => $user->user_id,
            'certificate_upload' => $linkToCert,
            'certificate_service_type' => $validated['service_type']
        ]);
        
        Auth::login($user);

        $token = $request->user()->createToken('userToken')->plainTextToken;

        return response()->json([
            'message' => "Successfully registered",
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function editPetOwner(Request $request, string $id)
    {
        $user = User::find($id);
        
        if($user) {
            $validated = $request->validate([
                'full_name' => 'required',
                'email' => ['required', 'email:rfc,dns'],
                'password' => ['required', Password::defaults(), 'confirmed'],
                'permission_level' => 'required',
                'contact_number' => ['required', 'regex:/^0[0-9]{9,10}$/'],
                'description' => 'required',
                'image' => 'image',
            ]);
    
            $password = Hash::make($validated['password']); // register for regular user
            
            if($request->hasFile('image'))
            {
                $profile = $request->file('image')->store('public/profile');
                $img = basename($profile);
                $linkToImage = asset('storage/profile/'.$img);
            }
    
            $user->update([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => $password,
                'contact_number' => $validated['contact_number'],
                'description' => $validated['description'],
                'image' =>  $linkToImage,
            ]);

            return response()->json([
                'message' => 'Succesfully edited user info!'
            ]);
        } else {
            return response()->json([
                'message' => 'User not found'
            ]);
        }
    }

    public function editServiceProvider(Request $request, string $id)
    {
        $user = User::find($id);
        
        if($user) {
            $validated = $request->validate([
                'full_name' => 'required',
                'email' => ['required', 'email:rfc,dns'],
                'password' => ['required', Password::defaults(), 'confirmed'],
                'contact_number' => ['required', 'regex:/^0[0-9]{9,10}$/'],
                'description' => 'required',
                'image' => 'required | image',
                'deposit_value' => 'required',
                'service_type' => 'required', Rule::in(['grooming', 'healthcare']),  
                'opening_hour' => 'required',
                'closing_hour' => 'required',
                'bank_name' => 'required',
                'beneficiary_acc_number' => 'required',
                'beneficiary_name' => 'required',
                'facility_location' => 'required',
                'qr_code_image' => 'required | image',
            ]);
    
            $password = Hash::make($validated['password']); // register for regular user
            
            if($request->hasFile('image'))
            {
                $profile = $request->file('image')->store('public/profile');
                $img = basename($profile);
                $linkToImage = asset('storage/profile/'.$img);
            }

            if($request->hasFile('qr_code_image')) 
            {
                $qr_code_image = $request->file('qr_code_image')->store('public/qr_code');
                $img2 = basename($qr_code_image);
                $linkToQR = asset('storage/qr_code/'.$img2);
            }
    
            $user->update([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => $password,
                'image' => $linkToImage,
                'contact_number' => $validated['contact_number'],
                'description' => $validated['description'],
                'deposit_value' => $validated['deposit_value'],
                'service_type' => $validated['service_type'],
                'opening_hour' => $validated['opening_hour'],
                'closing_hour' => $validated['closing_hour'],
                'bank_name' => $validated['bank_name'],
                'facility_location' => $validated['facility_location'],
                'beneficiary_acc_number' => $validated['beneficiary_acc_number'],
                'beneficiary_name' => $validated['beneficiary_name'],
                'qr_code_image' => $linkToQR,
            ]);

            return response()->json([
                'message' => 'Succesfully edited user info!'
            ]);
        } else {
            return response()->json([
                'message' => 'User not found'
            ]);
        }
    }

    // logout user
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'message' => 'User successfully logged out'
        ], 200);
    }

    // show user's info  
    public function profile() 
    {
        $user_id = auth('sanctum')->user()->user_id;

        $user = User::with('pets')->find($user_id);
        
        return response()->json([
            'user' => $user
        ]);
    }
}

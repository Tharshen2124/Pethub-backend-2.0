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

class UserController extends Controller
{
    //register new user
    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'permission_level' => 'required',
            'contact_number' => 'required',
            'description' => 'required',
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
            $image = $request->file('image')->store('public');
            [$public, $img] = explode("/",$image);
            $linkToImage = asset('storage/'.$img);
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
                'user_status' => 'accepted'
            ]);
        }

        elseif($permission_level === 2) // register for service provider
        {
            $SP_validated = $request->validate([
                'image' => 'required',
                'deposit_range' => 'required',
                'service_type' => 'required', Rule::in(['boarder', 'healthcare']),  
                'opening_hour' => 'required',
                'closing_hour' => 'required',
                'bank_name' => 'required',
                'beneficiary_acc_number' => 'required',
                'beneficiary_name' => 'required',
                'qr_code_image' => 'required | file',
                'sssm_certificate' => 'required | file',
            ]);

            if($request->hasFile('sssm_certificate') && $request->hasFile('qr_code_image'))
            {
                $qr_code_image = $request->file('qr_code_image')->store('public');
                [$public2, $img2] = explode("/",$image);
                $linkToQR = asset('storage/'.$img2);
                
                $sssm_certificate = $request->file('sssm_certificate')->store('public');
                [$public2, $img3] = explode("/",$image);
                $linkToCert = asset('storage/'.$img3);
            }

            $user = User::create([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => $password,
                'permission_level' => $permission_level,
                'image' => $linkToImage,
                'contact_number' => $validated['contact_number'],
                'description' => $validated['description'],
                'deposit_range' => $SP_validated['deposit_range'],
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

        if($auth) 
        {
            $token = $request->user()->createToken('userToken')->plainTextToken;
            return response()->json([
                'message' => 'Success!',
                'token' => $token,
                'user' => $request->user()
            ], 200);
        } else {
            $return =  [
                'message' => 'Error',
                'user' => null,
                'token' => null
            ];

            return response($return, 404);
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

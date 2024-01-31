<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Pet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;

class PetController extends Controller
{
    // store a new pet 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'pet_name' => 'required',
            'type' => 'required', 
            'description' => 'required',
            'age' => 'required',
            'image' => 'required | image',
        ]);

        Pet::create([
            'user_id' => $validated['user_id'],
            'pet_name' => $validated['pet_name'],
            'type' => $validated['type'], 
            'breed' => $request->breed,
            'description' => $validated['description'],
            'age' => $validated['age'],
            'image' => $validated['image'],
        ]);

        return response()->json([
            'message' => "Successfully added pet information!",
        ], 201);
    }

    // update pet information
    public function update(Request $request, string $id)
    {
        $pet = Pet::find($id);
        
        if($pet) {
            $validated = $request->validate([
                'user_id' => 'required',
                'pet_name' => 'required',
                'type' => 'required', 
                'description' => 'required',
                'age' => 'required',
                'image' => 'required | image',
            ]);
    
            $pet->update([
                'pet_name' => $validated['pet_name'],
                'type' => $validated['type'], 
                'breed' => $validated['breed'],
                'description' => $validated['decscription'],
                'age' => $validated['age'],
                'image' => $validated['image'],
            ]);
    
            return response()->json([
                'message' => "Successfully updated pet information!",
            ], 201);

        } else {
            return response()->json([
                'error' => 'Pet not found'
            ], 404);
        }
        
    }

    // delete a pet 
    public function destroy(string $id)
    { 
        $pet = Pet::find($id);
        
        if($pet) {
            $pet->delete();

            return response()->json([
                'message' => 'Successfully deleted pet information',
            ]);
        } else {
            return response()->json([
                'error' => 'Pet not found'
            ], 404);
        }
    }
}

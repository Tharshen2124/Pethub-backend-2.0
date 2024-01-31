<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
   // show all categories
   public function index_post() 
   {
       $category = Category::where('is_deleted', 0)
       ->where('category_type', 'post')
       ->get();
       
       return response()->json([
           'categories' => $category
       ]);
   }

   public function index_news()
   {
       $category = Category::where('is_deleted', 0)
       ->where('category_type', 'news')
       ->get();

       return response()->json([
           'categories' => $category
       ]);
   }

   // Store a newly created category
   public function store(Request $request)
   {
       $validated = $request->validate([
           'category_name' => 'required',
           'category_type' => Rule::in(['news', 'post'])
       ]);
       
       Category::create([
           'category_name' => $validated['category_name'],
           'category_type' => $validated['category_type']
       ]);
       
       return response()->json([
           'message' => 'Successfully created category!',
       ], 201);        
   }

   // Update a category.
   public function update(Request $request, string $id)
   {
       $category = Category::findOrFail($id);

       $validated = $request->validate([
           'category_name' => 'required',
           'category_type' => Rule::in(['news', 'post'])
       ]);
       
       $category->update([
           'category_name' => $validated['category_name'],
           'category_type' => $validated['category_type']
       ]);
       
       return response()->json([
           'message' => 'Successfully updated category!',
       ]);   
   }

   // Delete a category
   public function destroy(string $id)
   {
       $category = Category::findOrFail($id);
       
       $category->update([
           'is_deleted' => 1
       ]);
       
       return response()->json([
           'message' => 'Successfully deleted category!',
       ]);   
   }
}

<?php

namespace App\Http\Controllers\api;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')
                                ->paginate(5);

        return response()->json([
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories',
        ]);

        $category = new Category();
        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']);

        $category->save();

        return response()->json([
            'success' => 'Category created Successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        if (!$category) {

            return response()->json([
                'error' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'error' => 'Category not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => [ 'required', 'string', Rule::unique('categories')->ignore($category->id) ]
        ]);

        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']);

        $category->update();

        return response()->json([
            'success' => $category->name . 'Edited Successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'error' => 'Category not found'
            ]);
        }

        $category->delete();

        return response()->json([
            'info' => $category->name . 'Deleted Successfully',
        ]);
    }
}

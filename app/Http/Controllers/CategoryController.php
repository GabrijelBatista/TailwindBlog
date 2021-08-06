<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function get_categories(){
        $categories=Category::select('name', 'id')->get()->all();
        $categories=collect($categories)->sortBy('name');
        $categories->values()->all();
        return response()->json($categories);
    }

    public function add_category(Request $request){
        $request->validate([
            'name' => 'required|unique:categories',
        ]);
        Category::create(
            [
                'name' => $request->name
            ]
        );
        $categories=Category::select('name', 'id')->get()->all();
        $categories=collect($categories)->sortBy('name');
        $categories->values()->all();
        return response()->json($categories);
    }

    public function delete_category(Request $request){
        Category::where('id', $request->id)->first()->delete();
        $categories=Category::select('name', 'id')->get()->all();
        $categories=collect($categories)->sortBy('name');
        $categories->values()->all();
        return response()->json($categories);
    }
}

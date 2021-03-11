<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request) {
        $category = new Category();


        if ($request->has('query')) {
            $query = $request->get('query');
            $category = $category->where(function($q) use($query){
                $q->where('name', 'LIKE', "%$query%")->orWhere('description', 'LIKE', "%$query%");
            });
        }

        $category = $category->where('company_id',Auth::user()->company_id)->paginate(50);

        return response()->json($category);
    }

    public function edit(category $category) {
        if ($category) {
            return response()->json($category);
        }

        return response()->json([
            'message' => 'The category is not available.'
        ], 404);
    }
    public function update(Category $category,Request $request) {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,'.$category->id,
        ]);

        if ($category) {
            $category->name = $request->get('name');
            $category->description= $request->get('description');
            $category->save();
            return response()->json($category);
        }

        return response()->json([
            'message' => 'The category is not available.'
        ], 404);
    }
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|unique:categories,name',
        ]);
        $category = new Category();

        $category->name = $request->get('name');
        $category->description= $request->get('description');
        $category->user_id= Auth::user()->id;
        $category->company_id= Auth::user()->company_id;
        $category->save();

        return response()->json($category);

        return response()->json([
            'message' => 'Cannot create category'
        ], 404);
    }

    public function destroy(Category $category) {
        if ($category) {
            $category->delete();
        }

        return response()->json([
            'message' => 'The category removed successfully!'
        ]);
    }
}

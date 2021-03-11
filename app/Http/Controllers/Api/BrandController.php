<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function index(Request $request) {
        $brands = new Brand();


        if ($request->has('query')) {
            $query = $request->get('query');
            $brands = $brands->where(function($q) use($query){
                $q->where('name', 'LIKE', "%$query%")->orWhere('email', 'LIKE', "%$query%")->orWhere('phone', 'LIKE', "%$query%")->orWhere('address', 'LIKE', "%$query%");
            });
        }

        $brands = $brands->where("company_id",Auth::user()->company_id)->paginate(50);

        return response()->json($brands);
    }

    public function edit(Brand $brand) {
        if ($brand) {
            return response()->json($brand);
        }

        return response()->json([
            'message' => 'The brand is not available.'
        ], 404);
    }

    public function update(Brand $brand,Request $request) {

        if ($brand) {
            $brand->name = $request->get('name');
            $brand->email = $request->get('email');
            $brand->phone = $request->get('phone');
            $brand->address = $request->get('address');
            $brand->description= $request->get('description');
            $brand->save();
            return response()->json($brand);
        }

        return response()->json([
            'message' => 'The brand is not available.'
        ], 404);
    }
    public function store(Request $request) {

        $brand = new Brand();

        $brand->name = $request->get('name');
        $brand->description= $request->get('description');
        $brand->email = $request->get('email');
        $brand->phone = $request->get('phone');
        $brand->address = $request->get('address');
        $brand->user_id= Auth::user()->id;
        $brand->company_id= Auth::user()->company_id;
        $brand->save();

        return response()->json($brand);

        return response()->json([
            'message' => 'Cannot create brand'
        ], 404);
    }

    public function destroy(Brand $brand) {
        if ($brand) {
            $brand->delete();
        }

        return response()->json([
            'message' => 'The brand removed successfully!'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::paginate(50);
        return view('pages.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:brands'
        ]);

        $brand = new Brand();
        $brand->name = $request->get('name');
        $brand->company_id = 1;
        $brand->address = $request->get('address');
        $brand->user_id = Auth::user()->id;
        $brand->phone = $request->get('phone');
        $brand->email = $request->get('email');
        $brand->description = $request->get('description') ?? null;
        $brand->save();

        return redirect()->back()->with('success', 'Brand added successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        if (!$brand) {
            return redirect()->back()->with('warning', 'The brand you wanted to edit does not exist.');
        }

        return view('pages.brands.edit', compact('brand'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        if (!$brand) {
            return redirect()->back()->with('warning', 'The brand you wanted to edit does not exist.');
        }

        $this->validate($request, [
            'name' => 'required|unique:categories,name,' . $brand->id
        ]);

        $brand->name = $request->get('name');
        $brand->address = $request->get('address');
        $brand->phone = $request->get('phone');
        $brand->email = $request->get('email');
        $brand->description = $request->get('description') ?? null;
        $brand->save();

        return redirect()->action('BrandController@index')->with('success', 'brand updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        if ($brand) {
            $brand->delete();
        }

        return redirect()->action('BrandController@index')->with('success', 'brand deleted successfully!');
        }
}

<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Customer;
use App\Order;
use App\Product;
use App\Supplier;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('company_id', 1)->paginate(50);
        $categories = Category::where('company_id', 1)->get();
        $brands = Brand::where('company_id', 1)->get();
        $units = Unit::all();
        $customers = Customer::where('company_id', 1)->get();

        return view('pages.products.index', compact('categories', 'brands', 'units', 'customers', 'products'));
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
            'name' => 'required',
            'unit' => 'required|exists:units,id',
            'brand' => 'required|exists:brands,id',
            'category' => 'required|exists:categories,id',
        ]);

        $product = new Product();
        $product->company_id = 1;
        $product->name = $request->get('name');
        $product->unit_id = $request->get('unit');
        $product->user_id = Auth::user()->id;
        $product->brand_id = $request->get('brand');
        $product->category_id = $request->get('category');
        $product->description = $request->get('description') ?? '';
        $product->save();

        return redirect()->action('ProductController@show', $product->id)->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $customers = Customer::all();
        $products = Product::all();

        $product = Product::with(['unit', 'brand', 'category'])->find($id);
        $stocks = $product->stocks()->where("status", 1)->latest()->get();
        $suppliers = Supplier::all();

        // $recentOrders = Order::where("product_id",$id)->latest()->take(5)->get();
        return view('pages.products.show', compact('product', 'suppliers', 'stocks', 'customers', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if (!$product) {
            return redirect()->back()->with('warning', 'The product you wanted to edit does not exist.');
        }
        $categories = Category::all();
        $brands = Brand::all();
        $units = Unit::all();
        $customers = Customer::all();

        return view('pages.products.edit', compact('product', 'categories', 'brands', 'units', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if (!$product) {
            return redirect()->back()->with('warning', 'The product you wanted to edit does not exist.');
        }

        $this->validate($request, [
            'name' => 'required',
            'unit' => 'required|exists:units,id',
            'brand' => 'required|exists:units,id',
            'category' => 'required|exists:units,id',
        ]);

        $product->name = $request->get('name');
        $product->unit_id = $request->get('unit');
        $product->brand_id = $request->get('brand');
        $product->category_id = $request->get('category');
        $product->description = $request->get('description') ?? '';
        $product->save();

        return redirect()->action('ProductController@show', $product->id)->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product) {
            $product->delete();
        }

        return redirect()->action('ProductController@index')->with('success', 'Product deleted successfully!');
    }
}

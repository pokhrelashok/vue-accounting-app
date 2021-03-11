<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Category;
use App\Customer;
use App\Order;
use App\Stock;
use App\Product;
use App\Supplier;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::with(['unit', 'brand', 'category'])->where('company_id', Auth::user()->company_id);

        if ($request->get('query')) {
            $q = $request->get('query');
            $products = $products->where('name', 'LIKE', "%$q%")->orwhere('description', 'LIKE', "%$q%");
        }

        $products = $products->paginate(50);

        $categories = Category::where('company_id', Auth::user()->company_id)->get();
        $brands = Brand::where('company_id', Auth::user()->company_id)->get();

        return response()->json([$products, $categories, $brands], 200);
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
            'brand' => 'required|exists:brands,id',
            'category' => 'required|exists:categories,id',
        ]);

        $product = new Product();

        $product->company_id = Auth::user()->company_id;
        $product->name = $request->get('name');
        $product->user_id = Auth::user()->id;
        $product->brand_id = $request->get('brand');
        $product->category_id = $request->get('category');
        $product->description = $request->get('description') ?? '';

        $product->save();

        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

        $product = Product::with(['unit', 'brand', 'category'])->where('company_id', Auth::user()->company_id)->find($id);

        $stocks = Stock::with('supplier', 'unit')->where("product_id", $id)->where('quantity', '>', 0);

        $units = Unit::all();

        if ($request->get("query") == "custom") {
            $stocks = $stocks->whereBetween("created_at", [$request->get('date')['0'], $request->get('date')['1']])->take(10);
        } else if ($request->get("query") == "today") {
            $stocks = $stocks->where("created_at", ">=", Carbon::today())->take(10);
        } else if ($request->get("query") == "this_week") {
            $stocks = $stocks->with('supplier')->where("created_at", ">=", Carbon::now()->startOfWeek())->take(10);
        } else if ($request->get("query") == "this_month") {
            $stocks = $stocks->where("created_at", ">=", Carbon::now()->startOfMonth())->take(10);
        }

        $stocks = $stocks->get();

        $suppliers = Supplier::where('company_id', Auth::user()->company_id)->get();

        return response()->json([$product, $stocks, $suppliers, $units], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with(['unit', 'brand', 'category'])->find($id);
        if (!$product) {
            return redirect()->back()->with('warning', 'The product you wanted to edit does not exist.');
        }

        return response()->json($product, 200);
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
            return response()->json("The product doesnot exist!", 404);
        }
        $this->validate($request, [
            'name' => 'required',
            'brand' => 'required|exists:brands,id',
            'category' => 'required|exists:categories,id',
        ]);

        $product->company_id = Auth::user()->company_id;
        $product->name = $request->get('name');
        $product->user_id = Auth::user()->id;
        $product->brand_id = $request->get('brand');
        $product->category_id = $request->get('category');
        $product->description = $request->get('description') ?? '';

        $product->save();

        return response()->json($product);
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
            return response()->json("Product deleted successfully", 200);
        }
        return response()->json("Product not found", 404);
    }


    public function searchProducts(Request $request)
    {
        $query = $request->get('query');
        $products = Product::with(['stocks' => function ($query) {
            $query->where('status', 1)->where('quantity', '>', 0)->with("unit");
        }, 'brand', 'unit'])->where('name', 'LIKE', "%$query%")->orWhere('description', 'LIKE', "%$query%")->get();
        return response()->json($products);
    }
}

<?php

namespace App\Http\Controllers;

use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'product_id' => 'required|exists:products,id',
            'supplier' => 'required|exists:suppliers,id',
            'quantity' => 'required',
            'cost_price' => 'required',
            'selling_price' => 'required',
            'added_at' => 'required|date',
            'manufactured_at' => 'sometimes|date',
            'expires_at' => 'sometimes|date',
        ]);

        $stock = new Stock();

        $stock->product_id = $request->get('product_id');
        $stock->user_id = Auth::user()->id;
        $stock->supplier_id = $request->get('supplier');
        $stock->quantity = $request->get('quantity');
        $stock->cost_price = $request->get('cost_price');
        $stock->selling_price = $request->get('selling_price');
        $stock->special_price = $request->get('special_price') ?? null;
        $stock->color = $request->get('color') ?? null;
        $stock->size = $request->get('size') ?? null;
        $stock->added_at = $request->get('added_at') ?? null;
        $stock->manufactured_at = $request->get('manufactured_at') ?? null;
        $stock->expires_at = $request->get('expires_at') ?? null;

        $dimensions = null;
        if ($request->get('length') || $request->get('length') || $request->get('length')) {
            $dimensions  = [
                'length'=>$request->get('length'),
                'breadth'=>$request->get('breadth'),
                'height'=>$request->get('height')
            ];
        }
        $stock->dimensions = $dimensions;
        
        $stock->keywords = $request->get('keywords');
        $stock->remarks = $request->get('remarks');
        
        $stock->save();

        return redirect()->action('ProductController@show', $stock->product_id)->with('success', 'Stock added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}

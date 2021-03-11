<?php

namespace App\Http\Controllers\Api;

use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\StockCreator;

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
    public function store(Request $request, StockCreator $stock)
    {

        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'supplier' => 'required|exists:suppliers,id',
            'quantity' => 'required',
            'cost_price' => 'required',
            'selling_price' => 'required',
            'added_at' => 'required|date',
        ]);

        $stock = $stock->create($request->get('product_id'), Auth::user()->id, $request->get('supplier'), $request->get('quantity'), $request->get('cost_price'), $request->get('selling_price'), $request->get('special_price'), $request->get('color'), $request->get('size'), $request->get('added_at'), $request->get('manufactured_at'), $request->get('expires_at'), $request->get('len'), $request->get('breadth'), $request->get('height'), $request->get('keywords'), $request->get('remarks'), $request->get('status'));

        return response()->json($stock, 200);
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

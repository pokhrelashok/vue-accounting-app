<?php

namespace App\Http\Controllers;

use App\Order;
use App\Company;
use App\Customer;
use App\Supplier;
use App\Product;
use Auth;
// use App\OrderItem;
use App\Stock;
use Illuminate\Http\Request;
use App\Services\OrderCreator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = Customer::all();
        $suppliers = Supplier::all();
        $products = Product::all();
        $orders = Order::all();
        return view('orders.index',compact('orders','companies','customers','suppliers','products'));
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
    public function store(Request $request,OrderCreator $order)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'customer' => 'sometimes|exists:customers,id',
            'supplier' => 'sometimes|exists:suppliers,id',
        ]);

        $order = $order->create(Auth::user()->company_id,Auth::id(),$request->get("entity"),$request->get("customer"),$request->get("supplier"),$request->get("name"),$request->get("type"),$request->get("status"),$request->get("description"));

        if($request->get('type')=='purchase'){

            foreach($request->get("stock_purchase_quantity") as $key=>$v){

                $stock = new Stock();
                $stock->product_id = $request->get('product');
                $stock->user_id = Auth::id();
                $stock->supplier_id = $request->get('supplier');
                $stock->quantity = $request->get('stock_purchase_quantity')[$key];
                $stock->cost_price = $request->get('stock_purchase_cost_price')[$key];
                $stock->selling_price = $request->get('stock_purchase_selling_price')[$key];
                $stock->special_price = $request->get('stock_purchase_special_price')[$key] ?? null;
                $stock->color = $request->get('stock_purchase_color')[$key] ?? null;
                $stock->size = $request->get('stock_purchase_size')[$key] ?? null;
                $stock->added_at = $request->get('stock_purchase_added_at')[$key] ?? null;
                $stock->manufactured_at = $request->get('stock_purchase_manufactured_at')[$key] ?? null;
                $stock->expires_at = $request->get('stock_purchase_expires_at')[$key] ?? null;

                $dimensions = null;
                if ($request->get('stock_purchase_length')[$key] || $request->get('stock_purchase_length')[$key] || $request->get('stock_purchase_length')[$key]) {
                    $dimensions  = [
                        'length'=>$request->get('stock_purchase_length')[$key],
                        'breadth'=>$request->get('stock_purchase_breadth')[$key],
                        'height'=>$request->get('stock_purchase_height')[$key]
                    ];
                }
                $stock->dimensions = $dimensions;

                $stock->keywords = $request->get('stock_purchase_keywords')[$key];
                $stock->remarks = $request->get('stock_purchase_remarks')[$key];
                $stock->status = 0;

                $stock->save();

                $order->stocks()->attach( $stock->id, ["metadata"=>json_encode([
                    "product_id" =>$request->get("product"),
                    "supplier_id" =>$request->get('supplier'),
                    "quantity" =>$stock->quantity,
                    "cost_price" =>$stock->cost_price,
                    "color" =>$stock->color,
                    "size" =>$stock->size,
                    "dimensions" =>$stock->dimensions,
                    "added_at" =>$stock->added_at,
                ]),"user_id"=>Auth::id(),"quantity"=>$stock->quantity]);
            }
        }else{
            $stockIds = $request->get("selectedSellStocks");
            foreach($stockIds as $stockId){
                $stock = Stock::find($stockId);
                $stock->quantity -= $request->get('stock_sell_quantity')[$stockId];
                $stock->save();
                $order->stocks()->attach( $stock->id, ["metadata"=>json_encode([
                    "product_id" =>$request->get("product"),
                    "supplier_id" =>$request->get('supplier'),
                    "quantity" =>$stock->quantity,
                    "cost_price" =>$stock->cost_price,
                    "color" =>$stock->color,
                    "unit_id"=>$stock->unit->id,
                    "size" =>$stock->size,
                    "dimensions" =>$stock->dimensions,
                    "added_at" =>$stock->added_at,
                ]),"user_id"=>Auth::id(),"quantity"=>$request->get('stock_sell_quantity')[$stockId]]);
            }
        }
        return redirect()->action('ProductController@show',$request->get('product') )->with('success', 'Order created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $companies = Company::all();
        $customers = Customer::all();
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('orders.edit',compact('order','companies','customers','suppliers','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $this->validate($request, [
            'name' => 'required',
            'customer' => 'sometimes|exists:customers,id',
            'supplier' => 'sometimes|exists:suppliers,id',
            'amount' => 'required',
        ]);

        if($request->get('entity') == 'Supplier'){
            $order->supplier_id = $request->get('supplier');
            $order->customer_id = null;
        }else{
            $order->customer_id = $request->get('customer');
            $order->supplier_id = null;
        }

        $order->name = $request->get('name');
        $order->type = $request->get('type') ?? null;
        $order->amount = $request->get('amount');
        $order->description = $request->get('description') ?? null;
        $order->status = $request->get('status');

        $order->save();

        return redirect()->action('OrderController@index')->with('success', 'Order Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->action('OrderController@index')->with('success', 'Order Deleted successfully!');
    }

    public function markAsCompleted($id){
        $order = Order::find($id);
        $order->status = 1;
        $order->save();


        foreach($order->stocks as $stock){
            $stock->status=1;
            $stock->save();
        }

        return redirect()->action('OrderController@index')->with('success', 'Order Status Updated successfully!');
    }
}

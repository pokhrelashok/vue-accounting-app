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
use App\Services\OrderCreator;
use App\Services\StockCreator;
use App\Services\BillCreator;
use App\Services\OrderProductCreator;
use App\Services\SupplierAccountCreator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = Customer::where('company_id', Auth::user()->company_id)->get();
        $suppliers = Supplier::where('company_id', Auth::user()->company_id)->get();

        $orders = Order::with(['customer', 'supplier']);

        if ($request->has('query')) {
            $query = $request->get('query');
            $orders = $orders->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%")->orWhere('description', 'LIKE', "%$query%")->orWhere('type', 'LIKE', "%$query%");
            });
        }
        $orders = $orders->where("company_id", Auth::user()->company_id)->latest()->paginate(50);

        $units = Unit::all();
        return response()->json([$orders, $customers, $suppliers, $units], 200);
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
    public function store(Request $request, OrderCreator $order)
    {
        $this->validate($request, [
            'order.customer' => 'required_without:supplier',
            'order.supplier' => 'required_without:customer',
            'order.entity' => 'required',
            'order.type' => 'required',
            'order.status' => 'required',
            'purchase_products.*.*.quantity' => 'sometimes|required',
            'purchase_products.*.*.cost_price' => 'sometimes|required',
            'purchase_products.*.*.selling_price' => 'sometimes|required',
            'purchase_products.*.*.status' => 'sometimes|required',
            'purchase_products.*.*.added_at' => 'sometimes|required',
            'sell_stocks.*.quantity' => 'sometimes|required',
            'sell_stocks.*.price' => 'sometimes|required',

        ]);

        $orderData = $request->get("order");


        if ($orderData['customer'] == 0 && $orderData['entity'] == 'Customer') {
            $customer = Customer::forceCreate(['company_id' => Auth::user()->company_id, 'user_id' => Auth::user()->id, 'name' => $request->get('new_customer')]);
            $orderData['customer'] = $customer->id;
        }

        $customer = Customer::where('id', $orderData['customer'])->first();
        $supplier = Supplier::where('id', $orderData['supplier'])->first();

        $order = $order->create(Auth::user()->company_id, Auth::id(), $orderData['entity'], $orderData['customer'], $orderData['supplier'], $orderData['name'], $orderData['type'], $orderData['status'], $orderData['added_at'], $orderData['total_price'], $orderData['total_paid'], $orderData['total_due']);

        $bill = new BillCreator();

        $account = new SupplierAccountCreator();

        if ($orderData['type'] == 'Purchase') {

            $stocks = $request->get('purchase_products');

            $bill = $bill->create($order->id, $order->name, Auth::user()->id, $customer->id ?? null, $supplier->id ?? null, "Purchase", $orderData['added_at'], [], [], $orderData['total_paid'], $orderData['total_price'], null, null);

            foreach ($request->get("selected_purchase_products") as $key => $selectedProduct) {
                foreach ($stocks[$selectedProduct['id']] as $newStock) {
                    $stock = new StockCreator();
                    $orderProduct = new OrderProductCreator();
                    $stock = $stock->create($selectedProduct['id'], Auth::user()->id, $orderData['supplier'], $newStock['quantity'], $newStock['cost_price'], $newStock['selling_price'], $newStock['special_price'] ?? null, $newStock['color'] ?? null, $newStock['size'] ?? null, $newStock['added_at'], $newStock['manufactured_at'] ?? null, $newStock['expires_at'] ?? null, $newStock['len'] ?? null, $newStock['breadth'] ?? null, $newStock['height'] ?? null, $newStock['keywords'] ?? null, $newStock['remarks'] ?? null, $orderData['status'], $newStock['unit']);
                    $orderProduct = $orderProduct->create($order, $stock->id, $stock->product->name, Auth::user()->id, $supplier->name ?? null, null, $newStock['quantity'], $newStock['cost_price'], $newStock['selling_price'], $newStock['color'] ?? null, $newStock['size'] ?? null, $newStock['added_at'], $newStock['clear_balance'], $stock->dimensions, $stock->unit->name);
                }
            }

            if ($supplier) $account = $account->create($bill->id, $supplier->id, $order->id, $orderData['total_price'], $orderData['total_paid'], $orderData['added_at']);
        } else {
            $stockIds = $request->get("selected_sell_stocks");
            $stocks = $request->get('sell_stocks');

            $bill = $bill->create($order->id, $order->name, Auth::user()->id, $customer->id ?? null, $supplier->id ?? null, "Sales", $orderData['added_at'], $stocks, $stockIds, $orderData['total_price'], $orderData['total_paid'], null, null);

            foreach ($stockIds as $stockId) {
                $stock = Stock::find($stockId);
                $stock->quantity -= $stocks[$stockId]['quantity'];
                $stock->save();

                $orderProduct = new OrderProductCreator();

                $orderProduct = $orderProduct->create($order, $stock->id, $stock->product->name, Auth::user()->id, $supplier->name ?? null, $customer->name ?? null, $stocks[$stockId]['quantity'], $stock->cost_price, $stocks[$stockId]['price'], $stock->color, $stock->size, $stock->added_at, $stocks[$stockId]['clear_balance'], $stock->dimensions, $stock->unit->name);
            }

            if ($supplier) $account = $account->create($bill->id, $supplier->id, $order->id, $orderData['total_paid'], $orderData['total_price'], $orderData['added_at']);
        }

        return response()->json($order, 200);
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
        $customers = Customer::all();
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('orders.edit', compact('order', 'customers', 'suppliers', 'products'));
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
            'customer' => 'sometimes|nullable|exists:customers,id',
            'supplier' => 'sometimes|nullable|exists:suppliers,id',
            'amount' => 'required',
        ]);

        if ($request->get('entity') == 'Supplier') {
            $order->supplier_id = $request->get('supplier');
            $order->customer_id = null;
        } else {
            $order->customer_id = $request->get('customer');
            $order->supplier_id = null;
        }

        $order->name = $request->get('name');
        $order->type = $request->get('type');
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
        foreach ($order->stocks as $stock) {
            if ($order->type == 'Purchase') {
                $stock->delete();
            } else {
                $stock->quantity += $stock->pivot['quantity'];
                $stock->save();
            }
        }
        $order->stocks()->detach();

        $order->delete();

        return response()->json($order, 200);
    }

    public function markOrderAsCompleted($id)
    {
        $order = Order::find($id);
        $order->status = 1;


        foreach ($order->stocks as $stock) {
            $stock->status = 1;
            $stock->save();
        }

        $order->save();
        return response()->json($order, 200);
    }


    public function searchProducts(Request $request)
    {
        $query = $request->get('query');
        $products = Product::with(['stocks' => function ($query) {
            $query->where('status', 1)->where('quantity', '>', 0)->with("unit");
        }, 'brand'])->where('name', 'LIKE', "%$query%")->orWhere('description', 'LIKE', "%$query%")->get();
        return response()->json($products);
    }
}

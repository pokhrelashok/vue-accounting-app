<?php

namespace App\Http\Controllers\Api;

use App\Sale;
use App\Brand;
use App\Category;
use App\Customer;
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
use App\Services\CustomerAccountCreator;
use Carbon\Carbon;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = Customer::where('company_id', Auth::user()->company_id)->get();
        $sales = Sale::with(['customer']);

        if ($request->get('date_filter')) {
            $filter = $request->get('date_filter');
            if ($filter == "custom") {
                $sales = $sales->whereBetween("created_at", [$request->get('date')['0'], $request->get('date')['1']]);
            } else if ($filter == "today") {
                $sales = $sales->where("created_at", ">=", Carbon::today());
            } else if ($filter == "this_week") {
                $sales = $sales->where("created_at", ">=", Carbon::now()->startOfWeek());
            } else if ($filter == "this_month") {
                $sales = $sales->where("created_at", ">=", Carbon::now()->startOfMonth());
            }
        }

        if ($request->has('query')) {
            $query = $request->get('query');
            $sales = $sales->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%")->orWhere('description', 'LIKE', "%$query%")->orWhere('type', 'LIKE', "%$query%");
            });
        }
        $sales = $sales->where("company_id", Auth::user()->company_id)->latest()->paginate(50);
        $products = Product::where('company_id', "=", Auth::user()->company_id)->get();
        return response()->json([$sales, $customers, $products], 200);
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
            'order.name' => 'required',
            'order.customer' => 'required|exists:customers,id',
            'sell_stocks.*.quantity' => 'sometimes|required',
            'sell_stocks.*.price' => 'sometimes|required',
            'sell_stocks.*.clear_balance' => 'sometimes|required',
        ]);

        $bill = new BillCreator();
        $sale  = new OrderCreator();

        $stock = new StockCreator();
        $account = new CustomerAccountCreator();

        $saleData = $request->get("order");

        $stockIds = $request->get("selected_sell_stocks");

        $stocks = $request->get('sell_stocks');


        if ($saleData['customer'] == 0) {
            $customer = Customer::forceCreate(['company_id' => Auth::user()->company_id, 'user_id' => Auth::user()->id, 'name' => $request->get('new_customer')]);
            $saleData['customer'] = $customer->id;
        }

        $customer = Customer::where('id', $saleData['customer'])->first();

        $sale = $sale->create("Sales", Auth::user()->company_id, Auth::id(),  $saleData['customer'], null, $saleData['name'], $saleData['status'], $saleData['added_at'], $saleData['total_price'], $saleData['total_paid'], $saleData['total_due']);

        $bill = $bill->create('Sales', $sale->id, $sale->name, Auth::user()->id, $customer->id, "Sales", $saleData['added_at'], $saleData['total_price'], $saleData['total_paid']);

        $account = $account->create($bill->id, $customer->id, $sale->id, $saleData['total_paid'], $saleData['total_price'], $saleData['added_at']);

        foreach ($stockIds as $stockId) {
            $stock = Stock::find($stockId);
            $stock->quantity -= $stocks[$stockId]['quantity'];
            $stock->save();
            $saleProduct = new OrderProductCreator();
            $saleProduct = $saleProduct->create($sale, $stock->id, $stock->product->name, Auth::user()->id, null, $customer->name ?? null, $stocks[$stockId]['quantity'], $stock->cost_price, $stocks[$stockId]['price'], $stock->color, $stock->size, $stock->added_at, $stock->dimensions);
        }

        return response()->json($sale, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();

        return response()->json($order, 200);
    }


    public function markAsCompleted($id)
    {
        $sale = Sale::find($id);
        $sale->status = 1;

        $sale->save();
        return response()->json($sale, 200);
    }
}

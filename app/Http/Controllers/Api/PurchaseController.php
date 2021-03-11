<?php

namespace App\Http\Controllers\Api;

use App\Purchase;
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
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\SupplierAccountCreator;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $suppliers = Supplier::where('company_id', Auth::user()->company_id)->get();

        $purchases = Purchase::with(['supplier']);

        if ($request->has('query')) {
            $query = $request->get('query');
            $purchases = $purchases->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%")->orWhere('description', 'LIKE', "%$query%")->orWhere('type', 'LIKE', "%$query%");
            });
        }

        if ($request->get('date_filter')) {
            $filter = $request->get('date_filter');
            if ($filter == "custom") {
                $purchases = $purchases->whereBetween("created_at", [$request->get('date')['0'], $request->get('date')['1']]);
            } else if ($filter == "today") {
                $purchases = $purchases->where("created_at", ">=", Carbon::today());
            } else if ($filter == "this_week") {
                $purchases = $purchases->where("created_at", ">=", Carbon::now()->startOfWeek());
            } else if ($filter == "this_month") {
                $purchases = $purchases->where("created_at", ">=", Carbon::now()->startOfMonth());
            }
        }

        $purchases = $purchases->where("company_id", Auth::user()->company_id)->latest()->paginate(50);

        return response()->json([$purchases, $suppliers], 200);
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
            'order.supplier' => 'required|exists:suppliers,id',
            'order.status' => 'required',
            'purchase_products.*.*.quantity' => 'sometimes|required',
            'purchase_products.*.*.cost_price' => 'sometimes|required',
            'purchase_products.*.*.selling_price' => 'sometimes|required',
            'purchase_products.*.*.status' => 'sometimes|required',
            'purchase_products.*.*.added_at' => 'sometimes|required',

        ]);

        $purchase = new OrderCreator();

        $purchaseData = $request->get("order");

        $stocks = $request->get('purchase_products');

        $supplier = Supplier::where('id', $purchaseData['supplier'])->first();

        $purchase = $purchase->create("Purchase", Auth::user()->company_id, Auth::id(), null, $purchaseData['supplier'], $purchaseData['name'], $purchaseData['status'], $purchaseData['added_at'], $purchaseData['total_price'], $purchaseData['total_paid'], $purchaseData['total_due']);

        $bill = new BillCreator();

        $account = new SupplierAccountCreator();

        $bill = $bill->create("Purchase", $purchase->id, $purchase->name, Auth::user()->id, $supplier->id, "Purchase", $purchaseData['added_at'], $purchaseData['total_price'], $purchaseData['total_paid']);

        foreach ($request->get("selected_purchase_products") as $key => $selectedProduct) {

            foreach ($stocks[$selectedProduct['id']] as $newStock) {
                $stock = new StockCreator();

                $purchaseProduct = new OrderProductCreator();

                $stock = $stock->create($selectedProduct['id'], Auth::user()->id, $purchaseData['supplier'], $newStock['quantity'], $newStock['cost_price'], $newStock['selling_price'], $newStock['special_price'] ?? null, $newStock['color'] ?? null, $newStock['size'] ?? null, $purchaseData['added_at'], $newStock['manufactured_at'] ?? null, $newStock['expires_at'] ?? null, $newStock['len'] ?? null, $newStock['breadth'] ?? null, $newStock['height'] ?? null, $newStock['keywords'] ?? null, $newStock['remarks'] ?? null, $purchaseData['status']);

                $purchaseProduct = $purchaseProduct->create($purchase, $stock->id, $stock->product->name, Auth::user()->id, $supplier->name ?? null, null, $newStock['quantity'], $newStock['cost_price'], $newStock['selling_price'], $newStock['color'] ?? null, $newStock['size'] ?? null, $purchaseData['added_at'], $stock->dimensions);
            }
        }

        $account = $account->create($bill->id, $supplier->id, $purchase->id, $purchaseData['total_price'], $purchaseData['total_paid'], $purchaseData['added_at']);

        return response()->json($purchase, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        return response()->json($purchase, 200);
    }

    public function markAsCompleted($id)
    {
        $purchase = Purchase::find($id);
        $purchase->status = 1;


        foreach ($purchase->stocks as $stock) {
            $stock->status = 1;
            $stock->save();
        }

        $purchase->save();
        return response()->json($purchase, 200);
    }
}

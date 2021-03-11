<?php

namespace App\Http\Controllers\Api;

use App\Supplier;
use App\Order;
use App\SupplierAccount;
use App\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Purchase;
use Carbon\Carbon;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $suppliers = new Supplier();

        if ($request->has('query')) {
            $query = $request->get('query');
            $suppliers = $suppliers->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%")->orWhere('phone_number', 'LIKE', "%$query%")->orWhere('address', 'LIKE', "%$query%")->orWhere('email', 'LIKE', "%$query%");
            });
        }

        $suppliers = $suppliers->where('company_id', Auth::user()->company_id)->latest()->paginate(50);
        return response()->json($suppliers);
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
            'email' => 'sometimes|email',
            'phone_number' => 'required|unique:suppliers,phone_number'
        ]);

        $supplier = new Supplier();

        $supplier->name = $request->get('name');
        $supplier->user_id = Auth::user()->id;
        $supplier->phone_number = $request->get('phone_number');
        $supplier->priority = $request->get('priority') == 'on' ? 1 : 0;
        $supplier->favorite = $request->get('favorite') == 'on' ? 1 : 0;
        $supplier->company_id = Auth::user()->company_id;
        $supplier->description = $request->get('description') ?? null;
        $supplier->email = $request->get('email') ?? null;
        $supplier->address = $request->get('address') ?? null;

        $supplier->save();

        return response()->json($supplier, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Supplier $supplier)
    {
        $bills = Bill::where('supplier_id', $supplier->id)->latest()->get();
        $accounts = SupplierAccount::with('bill', 'purchase')->where("supplier_id", $supplier->id)->oldest();

        // if ($request->get("query") == "custom") {
        //     $accounts = $accounts->whereBetween("created_at", $request->get("date"));
        // } else if ($request->get("query") == "today") {
        //     $accounts = $accounts->where("created_at", ">=", Carbon::today());
        // } else if ($request->get("query") == "this_week") {
        //     $accounts = $accounts->where("created_at", ">=", Carbon::now()->startOfWeek());
        // } else if ($request->get("query") == "this_month") {
        //     $accounts = $accounts->where("created_at", ">=", Carbon::now()->startOfMonth());
        // }


        $totalBalance = SupplierAccount::latest()->first()->balance;
        $accounts = $accounts->get()->groupBy('purchase_id');
        return response()->json([$supplier, $bills, $accounts, $totalBalance]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        if (!$supplier) {
            return response()->json("operation failed", 404);
        }

        return response()->json($supplier, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        if (!$supplier) {
            return redirect()->back()->with('warning', 'The supplier you wanted to edit does not exist.');
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'sometimes|email|unique:suppliers,email,' . $supplier->id,
            'phone_number' => 'required|unique:suppliers,phone_number,' . $supplier->id
        ]);


        $supplier->name = $request->get('name');
        $supplier->phone_number = $request->get('phone_number');
        $supplier->priority = $request->get('priority') == 'on' ? 1 : 0;
        $supplier->favorite = $request->get('favorite') == 'on' ? 1 : 0;
        $supplier->description = $request->get('description') ?? null;
        $supplier->email = $request->get('email') ?? null;
        $supplier->address = $request->get('address') ?? null;

        $supplier->save();

        return response()->json($supplier, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        if ($supplier) {
            $supplier->delete();
        }

        return response()->json($supplier, 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Supplier;
use App\Order;
use App\SupplierAccount;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::where('company_id', 1)->paginate(50);
        return view('pages.supplier.index', compact('suppliers'));
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
        $supplier->phone_number = $request->get('phone_number');
        $supplier->priority = $request->get('priority')=='on' ? 1 : 0;
        $supplier->favorite = $request->get('favorite')=='on' ? 1 : 0;
        $supplier->company_id = 1;
        $supplier->description = $request->get('description') ?? null;
        $supplier->email = $request->get('email') ?? null;
        $supplier->address = $request->get('address') ?? null;
        $supplier->save();

        return redirect()->back()->with('success', 'Supplier added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Supplier $supplier)
    {
        $orders = Order::all();
        if($request->get("filter")=="today"){
            $accounts = SupplierAccount::where("supplier_id",$supplier->id)->where("created_at",">=",Carbon::today())->latest()->get();
        }else if($request->get("filter")=="this_week"){
            $accounts = SupplierAccount::where("supplier_id",$supplier->id)->where("created_at",">=",Carbon::now()->startOfWeek())->latest()->get();
        }else if($request->get("filter")=="this_month"){
            $accounts = SupplierAccount::where("supplier_id",$supplier->id)->where("created_at",">=",Carbon::now()->startOfMonth())->latest()->get();
        }else{
            $accounts = SupplierAccount::where("supplier_id",$supplier->id)->where("supplier_id",$supplier->id)->latest()->get();
        }
        return view("pages.supplier.show",compact("supplier","orders","accounts"));
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
            return redirect()->back()->with('warning', 'The supplier you wanted to edit does not exist.');
        }

        return view('pages.supplier.edit', compact('supplier'));
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
        $supplier->priority = $request->get('priority')=='on' ? 1 : 0;
        $supplier->favorite = $request->get('favorite')=='on' ? 1 : 0;
        $supplier->description = $request->get('description') ?? null;
        $supplier->email = $request->get('email') ?? null;
        $supplier->address = $request->get('address') ?? null;
        $supplier->save();

        return redirect()->back()->with('success', 'Supplier updated successfully!');}

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

        return redirect()->action('SupplierController@index')->with('success', 'Supplier deleted successfully!');
    }
}

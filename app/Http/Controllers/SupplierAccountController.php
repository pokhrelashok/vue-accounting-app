<?php

namespace App\Http\Controllers;

use App\SupplierAccount;
use App\Supplier;
use Illuminate\Http\Request;

class SupplierAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = SupplierAccount::latest()->paginate(40);
        return view("pages.accounts.index",compact("accounts"));
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
            'supplier' => 'required|exists:suppliers,id',
            'order' => 'required|exists:orders,id',
        ]);

        $account = new SupplierAccount();

       $account->supplier_id = $request->get('supplier');
       $account->order_id = $request->get('order');
       $account->debit = $request->get('debit');
       $account->credit = $request->get('credit');
       $account->balance = $request->get('balance');

        $account->save();

        return redirect()->back()->with("success","Account Created Successfully!");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SupplierAccount  $supplierAccount
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierAccount $supplierAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SupplierAccount  $supplierAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplierAccount $supplierAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SupplierAccount  $supplierAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupplierAccount $supplierAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SupplierAccount  $supplierAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplierAccount $supplierAccount)
    {
        //
    }
}

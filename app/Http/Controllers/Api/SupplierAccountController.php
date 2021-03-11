<?php

namespace App\Http\Controllers\Api;

use App\SupplierAccount;
use App\Supplier;
use App\Services\BillCreator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Purchase;
use App\Services\SupplierAccountCreator;

class SupplierAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = SupplierAccount::all();
        return view("pages.accounts.index", compact("accounts"));
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
            'debit' => 'sometimes|nullable',
            'credit' => 'sometimes|nullable',
            'purchase_id' => 'required|exists:purchases,id',
        ]);

        $requestData = $request->all();
        $bill = new BillCreator();
        $bill = $bill->create('Purchase', $requestData['purchase_id'], $requestData['bill'], Auth::user()->id, $requestData['supplier'], $requestData['type'], $requestData['added_at'], $requestData['debit'], $requestData['credit']);


        $purchase = Purchase::find($requestData['purchase_id']);
        $purchase->total_paid += $requestData['credit'];
        $purchase->total_due -= $requestData['credit'];
        $purchase->save();


        $account = new SupplierAccountCreator();
        $account->create($bill->id, $requestData['supplier'], $requestData['purchase_id'], $requestData['debit'], $requestData['credit'], $requestData['added_at']);

        return response()->json($account, 200);
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

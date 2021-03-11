<?php

namespace App\Http\Controllers;

use App\CustomerAccount;
use App\Customer;
use Illuminate\Http\Request;

class CustomerAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = CustomerAccount::latest()->paginate(40);
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
            'customer' => 'required|exists:customers,id',
            'order' => 'required|exists:orders,id',
        ]);

        $account = new CustomerAccount();

        $account->customer_id = $request->get('customer');
        $account->order_id = $request->get('order');
        $account->debit = $request->get('debit');
        $account->credit = $request->get('credit');
        $account->balance = $request->get('balance');

        $account->save();

        return redirect()->back()->with("success", "Account Created Successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomerAccount  $CustomerAccount
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerAccount $CustomerAccount)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerAccount  $CustomerAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerAccount $CustomerAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerAccount  $CustomerAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerAccount $CustomerAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerAccount  $CustomerAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerAccount $CustomerAccount)
    {
        //
    }
}

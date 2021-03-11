<?php

namespace App\Http\Controllers\Api;

use App\CustomerAccount;
use App\Services\BillCreator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Sale;

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
            'debit' => 'sometimes|nullable',
            'credit' => 'sometimes|nullable',
            'sale_id' => 'required|exists:sales,id',
        ]);

        $requestData = $request->all();
        $bill = new BillCreator();
        $bill = $bill->create('Sales', $requestData['sale_id'], $requestData['bill'], Auth::user()->id, $requestData['customer'],  $requestData['type'], $requestData['added_at'], $requestData['debit'], $requestData['credit']);


        $sale = Sale::find($requestData['sale_id']);
        $sale->total_paid += $requestData['debit'];
        $sale->total_due -= $requestData['debit'];
        $sale->save();

        $account = new CustomerAccountController();
        $account->create($bill->id, $requestData['customer'], $requestData['sale_id'], $requestData['debit'], $requestData['credit'], $requestData['added_at']);

        return response()->json($account, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomerAccount  $CustomerAccount
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerAccount $CustomerAccount)
    {
        //
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

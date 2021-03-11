<?php

namespace App\Http\Controllers\Api;

use App\Bill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use PDF;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json("yeah", 200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bill  = Bill::with('supplier','customer')->find($id);
        $company = Auth::user()->company;

        return response()->json([$bill,$company], 200);
    }

    public function getBillData($id)
    {
        $bill  = Bill::with('supplier','customer')->find($id);
        return $bill;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        //
    }

    public function printBill($id){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convertDataToHtml($id));
        return $pdf->stream();
    }

    public function convertDataToHtml($id){
        $billData =$this->getBillData($id);
         if($billData->type=="Sales"){
             $output = '
     <h4 align="left">BIll Number : '.$billData->bill_number.'</h4>
     <h4 align="left">Date : '.$billData->added_at.'</h4>
     <h4 align="left">Name : '.$billData->supplier->name.'</h4>
     <table width="100%" style="border-collapse: collapse; border: 0px;">
     <tr>
        <th style="border: 1px solid; padding:12px;" width="20%">Product</th>
        <th style="border: 1px solid; padding:12px;" width="30%">Quantity</th>
        <th style="border: 1px solid; padding:12px;" width="15%">Price</th>
        <th style="border: 1px solid; padding:12px;" width="15%">Total Price</th>
        <th style="border: 1px solid; padding:12px;" width="20%">Total Paid</th>
        </tr>';


    foreach(json_decode($billData->metadata) as $ind=>$item){

        $output.='<tr>
       <td style="border: 1px solid; padding:12px;">'.$item->product.'</td>
       <td style="border: 1px solid; padding:12px;">'.$item->quantity.'</td>
       <td style="border: 1px solid; padding:12px;">Rs. '.$item->selling_price.'</td>
       <td style="border: 1px solid; padding:12px;">Rs. '.$item->total_price.'</td>
       <td style="border: 1px solid; padding:12px;">Rs. '.$item->clear_balance.'</td>
      </tr>
      ';
    }
    $output.='<tr>
       <td style="border: 1px solid; padding:12px;">Total</td>
       <td style="border: 1px solid; padding:12px;"></td>
       <td style="border: 1px solid; padding:12px;"></td>
       <td style="border: 1px solid; padding:12px;">Rs. '.$billData->total_cost.'</td>
       <td style="border: 1px solid; padding:12px;">Rs. '.$billData->total_paid.'</td>
      </tr>
      ';
    }
    else{
             $output = '
     <h4 align="left">BIll Number : '.$billData->bill_number.'</h4>
     <h4 align="left">Date : '.$billData->added_at.'</h4>
     <h4 align="left">Name : '.$billData->supplier->name.'</h4>
     <table width="100%" style="border-collapse: collapse; border: 0px;">
     <tr>
        <th style="border: 1px solid; padding:12px;" width="20%">Debit</th>
        <th style="border: 1px solid; padding:12px;" width="20%">Credit</th>
        </tr>';
    foreach(json_decode($billData->metadata) as $ind=>$item){
        $output.='<tr>
       <td style="border: 1px solid; padding:12px;">'.$item->debit.'</td>
       <td style="border: 1px solid; padding:12px;">'.$item->credit.'</td>
      </tr>
      ';
    }
}
      return $output;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        //
    }
}

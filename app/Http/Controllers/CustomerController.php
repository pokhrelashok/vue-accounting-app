<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::paginate(50);
        return view('pages.customers.index', compact('customers'));
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
            'phone_number' => 'required|unique:customers,phone_number'
        ]);

        $customer = new Customer();
        $customer->name = $request->get('name');
        $customer->phone_number = $request->get('phone_number');
        $customer->priority = $request->get('priority')=='on' ? 1 : 0;
        $customer->favorite = $request->get('favorite')=='on' ? 1 : 0;
        $customer->company_id = 1;
        $customer->user_id = Auth::user()->id;
        $customer->description = $request->get('description') ?? null;
        $customer->email = $request->get('email') ?? null;
        $customer->address = $request->get('address') ?? null;
        $customer->save();

        return redirect()->back()->with('success', 'Customer added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        if (!$customer) {
            return redirect()->back()->with('warning', 'The customer you wanted to edit does not exist.');
        }

        return view('pages.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        if (!$customer) {
            return redirect()->back()->with('warning', 'The customer you wanted to edit does not exist.');
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'sometimes|email|unique:customers,email,' . $customer->id,
            'phone_number' => 'required|unique:customers,phone_number,' . $customer->id
        ]);


        $customer->name = $request->get('name');
        $customer->phone_number = $request->get('phone_number');
        $customer->priority = $request->get('priority')=='on' ? 1 : 0;
        $customer->favorite = $request->get('favorite')=='on' ? 1 : 0;
        $customer->description = $request->get('description') ?? null;
        $customer->email = $request->get('email') ?? null;
        $customer->address = $request->get('address') ?? null;
        $customer->save();

        return redirect()->back()->with('success', 'Customer added successfully!');}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        if ($customer) {
            $customer->delete();
        }

        return redirect()->action('CustomerController@index')->with('success', 'Customer deleted successfully!');
    }
}

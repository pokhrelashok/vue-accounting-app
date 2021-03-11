<?php

namespace App\Http\Controllers\Api;

use App\Bill;
use App\Http\Controllers\Controller;
use App\Customer;
use App\CustomerAccount;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = new Customer();


        if ($request->has('query')) {
            $query = $request->get('query');
            $customers = $customers->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%")->orwhere('address', 'LIKE', "%$query%")->orwhere('phone_number', 'LIKE', "%$query%")->orwhere('email', 'LIKE', "%$query%");
            });
        }

        $customers = $customers->where('company_id', Auth::user()->company_id)->latest()->paginate(50);

        return response()->json($customers);
    }

    public function edit(Customer $customer)
    {
        if (!$customer) {
            return response()->json("operation failed", 404);
        }

        return response()->json($customer, 200);
    }

    public function show(Request $request, Customer $customer)
    {
        $bills = Bill::where('customer_id', $customer->id)->latest()->get();
        $accounts = CustomerAccount::with('bill', 'sale')->where("customer_id", $customer->id)->oldest();


        // if ($request->get("query") == "custom") {
        //     $accounts = $accounts->whereBetween("created_at", $request->get("date"));
        // } else if ($request->get("query") == "today") {
        //     $accounts = $accounts->where("created_at", ">=", Carbon::today());
        // } else if ($request->get("query") == "this_week") {
        //     $accounts = $accounts->where("created_at", ">=", Carbon::now()->startOfWeek());
        // } else if ($request->get("query") == "this_month") {
        //     $accounts = $accounts->where("created_at", ">=", Carbon::now()->startOfMonth());
        // }

        // $request->get("query") == "all" ? $accounts = $accounts->get() : $accounts = $accounts->take(10)->get();

        $totalBalance = CustomerAccount::latest()->first()->balance;
        $accounts = $accounts->get()->groupBy('sale_id');

        return response()->json([$customer, $bills, $accounts, $totalBalance]);
    }



    public function update(Customer $customer, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        if ($customer) {
            $customer->name = $request->get('name');
            $customer->email = $request->get('email');
            $customer->phone_number = $request->get('phone_number');
            $customer->address = $request->get('address');
            $customer->description = $request->get('description');
            $customer->save();
            return response()->json($customer);
        }

        return response()->json([
            'message' => 'The customer is not available.'
        ], 404);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $customer = new Customer();

        $customer->name = $request->get('name');
        $customer->description = $request->get('description');
        $customer->email = $request->get('email');
        $customer->phone_number = $request->get('phone_number');
        $customer->address = $request->get('address');
        $customer->user_id = Auth::user()->id;
        $customer->company_id = Auth::user()->company_id;
        $customer->save();

        return response()->json($customer);

        return response()->json([
            'message' => 'Cannot create customer'
        ], 404);
    }

    public function destroy(Customer $customer)
    {
        if ($customer) {
            $customer->delete();
        }

        return response()->json([
            'message' => 'The customer removed successfully!'
        ]);
    }
}

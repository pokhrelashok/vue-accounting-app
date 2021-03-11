<?php

namespace App\Services;

use App\CustomerAccount;

class CustomerAccountCreator
{
    public function create($bill_id, $customer_id, $sale_id, $debit = 0, $credit = 0, $added_at)
    {
        $balance = CustomerAccount::where('customer_id', $customer_id)->latest()->first()->balance ?? 0;

        return CustomerAccount::forceCreate([
            "bill_id" => $bill_id,
            "customer_id" => $customer_id,
            "sale_id" => $sale_id,
            "debit" => $debit ?? 0,
            "credit" => $credit ?? 0,
            "added_at" => $added_at,
            "balance" => $balance + $debit - $credit,
        ]);
    }
}

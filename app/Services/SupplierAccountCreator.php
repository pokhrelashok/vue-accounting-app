<?php

namespace App\Services;

use App\SupplierAccount;

class SupplierAccountCreator
{
    public function create($bill_id, $supplier_id, $purchase_id, $debit = 0, $credit = 0, $added_at)
    {
        $balance = SupplierAccount::where('supplier_id', $supplier_id)->latest()->first()->balance ?? 0;

        return SupplierAccount::forceCreate([
            "bill_id" => $bill_id,
            "supplier_id" => $supplier_id,
            "purchase_id" => $purchase_id,
            "debit" => $debit ?? 0,
            "credit" => $credit ?? 0,
            "added_at" => $added_at,
            "balance" => $balance + $debit - $credit,
        ]);
    }
}

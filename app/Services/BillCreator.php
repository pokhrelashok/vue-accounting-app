<?php

namespace App\Services;

use App\Bill;
use App\Stock;

class BillCreator
{
    public function create($orderType, $order_id, $bill_number, $user_id, $client_id, $type, $added_at, $total_cost, $total_paid)
    {
        // $metadata = [];
        // foreach ($stockIds as $stockId) {
        //     $stock = Stock::find($stockId);
        //     $metadata[] = [
        //         "product" => $stock->product->name,
        //         "quantity" => $stocks[$stockId]['quantity'],
        //         "selling_price" => $stocks[$stockId]['price'],
        //         "total_price" => $stocks[$stockId]['quantity'] * $stocks[$stockId]['price'],
        //         "clear_balance" => $stocks[$stockId]['clear_balance'],
        //     ];
        // }
        // if ($debit || $credit) $metadata[] = ["debit" => $debit, "credit" => $credit];

        return Bill::forceCreate([
            "sale_id" => $orderType == 'Sales' ? $order_id : null,
            "purchase_id" => $orderType == 'Purchase' ? $order_id : null,
            "bill_number" => $bill_number,
            "user_id" => $user_id,
            "customer_id" => $orderType == 'Sales' ? $client_id : null,
            "supplier_id" => $orderType != 'Sales' ? $client_id : null,
            "type" => $type,
            "total_cost" => $total_cost ?? 0,
            "total_paid" => $total_paid ?? 0,
            "added_at" => $added_at
        ]);
    }
}

<?php

namespace App\Services;

use App\Sale;
use App\Purchase;
use Illuminate\Support\Str;

class OrderCreator
{
    public function create($type, $company_id, $user_id, $customer_id, $supplier_id, $name, $status, $added_at, $total_price, $total_paid, $total_due)
    {
        $data = [
            "order_id" => Str::random(16),
            "company_id" => $company_id,
            "user_id" => $user_id,
            "name" => $name,
            "type" => $type,
            "status" => $status,
            "added_at" => $added_at,
            "total_price" => $total_price,
            "total_paid" => $total_paid,
            "total_due" => $total_due,
        ];
        if ($type == "Sales") {
            $data["customer_id"] = $customer_id;
            return  Sale::forceCreate($data);
        } else {
            $data["supplier_id"] = $supplier_id;
            return Purchase::forceCreate($data);
        }
    }
}

<?php

namespace App\Services;

class OrderProductCreator
{
    public function create($order, $stock_id, $product, $user_id, $supplier = null, $customer = null, $quantity, $cost_price, $selling_price, $color, $size, $added_at, $dimensions)
    {
        $metadata = [
            "product" => $product,
            "supplier" => $supplier,
            "customer" => $customer,
            "quantity" => $quantity,
            "cost_price" => $cost_price,
            "selling_price" => $selling_price,
            "color" => $color,
            "size" => $size,
            "dimensions" => $dimensions,
            "added_at" => $added_at,
        ];

        return $order->stocks()->attach($stock_id, [
            "metadata" => json_encode($metadata), "user_id" => $user_id, "quantity" => $quantity, 'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);
    }
}

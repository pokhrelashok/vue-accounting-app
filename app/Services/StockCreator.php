<?php

namespace App\Services;

use App\Stock;

class StockCreator
{
    public function create($product_id, $user_id, $supplier, $quantity, $cost_price, $selling_price, $special_price, $color, $size, $added_at, $manufactured_at, $expires_at, $length, $breadth, $height, $keywords, $remarks, $status = 1)
    {

        $dimensions = null;
        if ($length || $breadth || $height) {
            $dimensions  = [
                'length' => $length,
                'breadth' => $breadth,
                'height' => $height
            ];
        }
        return Stock::forceCreate([
            'product_id' => $product_id,
            'user_id' => $user_id,
            'supplier_id' => $supplier,
            'quantity' => $quantity,
            'cost_price' => $cost_price,
            'selling_price' => $selling_price,
            'special_price' => $special_price,
            'color' => $color,
            'size' => $size,
            'added_at' => $added_at ?? null,
            'manufactured_at' => $manufactured_at ?? null,
            'expires_at' => $expires_at ?? null,
            'dimensions' => $dimensions,
            'keywords' => $keywords,
            'remarks' => $remarks,
            'status' => $status,
        ]);
    }
}

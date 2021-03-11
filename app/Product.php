<?php

namespace App;

use App\OrderItem;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * All the orders of this product
     */
    // public function orders() {
    // 	return $this->hasManyThrough(Order::class, OrderProduct::class, 'order_id', 'id');
    // }

    public function orderItems()
    {
        return $this->hasManyThrough(OrderProduct::class);
    }

    /**
     * All the stock of this product
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $casts = [
        'dimensions' => 'array',
    ];


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

}

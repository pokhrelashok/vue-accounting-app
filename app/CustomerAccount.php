<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerAccount extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}

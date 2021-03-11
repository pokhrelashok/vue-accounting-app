<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierAccount extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}

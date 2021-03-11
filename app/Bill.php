<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}

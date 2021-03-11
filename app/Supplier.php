<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public function accounts()
    {
        return $this->hasMany(SupplierAccount::class);
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}

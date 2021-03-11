<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function product() {
    	return $this->belongsTo(Product::class);
    }

    public function user() {
    	return $this->belongsTo(User::class);
    }
    public function stocks() {
    	return $this->belongsToMany(Stock::class,'sale_products')->withPivot(['quantity','metadata']);
    }
    public function orderProducts() {
    	return $this->hasMany(SaleProduct::class);
    }
    public function bill() {
    	return $this->belongsTo(Bill::class,'sale_id');
    }
    public function account(){
        return $this->belongsTo(SupplierAccount::class);
    }

}

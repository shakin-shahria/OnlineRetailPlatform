<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'product_id';

    public function product_images(){
        return $this->hasOne('App\Models\ProductImage', 'product_id', 'product_id');
    }

    public function getCategory(){
        return $this->hasOne('App\Models\Category', 'category_row_id', 'category_id');
    }

    public function product_inventory(){
        return $this->hasOne('App\Models\ProductInventory', 'product_id', 'product_id');
    }

    public function product_attribute(){
        return $this->hasMany('App\Models\ProductAttribute', 'product_id', 'product_id');
    }
}

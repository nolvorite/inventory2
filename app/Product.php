<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'product_category_id', 'price', 'stock', 'stock_defective', 'selling_price', 'product_quantity', 'buying_date', 'company_name'
    ];

    public static function catJoin(){
        return (new static)::select(DB::Raw('*,product_categories.name as product_name, products.id AS product_id'))->join("product_categories","product_category_id","=","product_categories.id");
    }

    public function category()
    {
        return $this->belongsTo('App\ProductCategory', 'product_category_id')->withTrashed();
    }

    public function solds()
    {
        return $this->hasMany('App\SoldProduct');
    }

    public function receiveds()
    {
        return $this->hasMany('App\ReceivedProduct');
    }
}

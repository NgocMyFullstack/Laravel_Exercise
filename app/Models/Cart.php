<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable=['user_id','produdct_id','order_id','quantity','amount','price','status'];
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function order(){
        return  $this->belongsTo(Order::class,'order_id');
    }
}

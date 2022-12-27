<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;
use App\Models\Customer;
use App\Models\Order;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'mst_order_detail';
    // default id
    protected $primaryKey = 'order_id';
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'detail_line',
        'product_id',
        'price_buy',
        'quantity',
        'shop_id',
        'receiver_id',
    ];

    public function shop(){
        return $this->belongsTo(Shop::class, 'shop_id', 'shop_id');
    }
    public function product(){
        return $this->belongsTo(Customer::class, 'product_id', 'product_id');
    }
    public function order(){
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}

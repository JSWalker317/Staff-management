<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\OrderDetail;

class Order extends Model
{
    use HasFactory;

    protected $table = 'mst_order';
    // default id
    protected $primaryKey = 'order_id';
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_shop',
        'customer_id',
        'total_price',
        'payment_method',
        'ship_charge',
        'tax',
        'order_date',
        'shipment_date',
        'cancel_date',
        'order_status',
        'note_customer',
        'error_code_api',
    ];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class, 'product_id', 'product_id');
    }
}

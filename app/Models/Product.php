<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail;

class Product extends Model
{
    use HasFactory;
    // becuz primary is string if dafault true, the value id is 0 for string
    public $incrementing = false;
    protected $table = 'mst_product';
    // default id
    protected $primaryKey = 'product_id';
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_name',
        'product_image',
        'product_price',
        'is_sales',
        'is_sales',
    ];

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class, 'product_id', 'product_id');
    }

}

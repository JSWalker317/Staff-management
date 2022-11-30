<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail;

class Shop extends Model
{
    use HasFactory;

    protected $table = 'mst_shop';
    // default id
    protected $primaryKey = 'shop_id';
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop_name',
    ];



    public function orderDetails(){
        return $this->hasMany(OrderDetail::class, 'product_id', 'product_id');
    }
}

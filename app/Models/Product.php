<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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

}

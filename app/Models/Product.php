<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'product_name',
        'product_code',
        'product_barcode_symbology',
        'product_quantity',
        'product_cost',
        'product_price',
        'product_unit',
        'product_stock_alert',
        'product_order_tax',
        'product_tax_type',
        'product_note',
        'status',
        'created_by',
        'temp_status',
        'temp',
        'user_name',
        'note',
    ];
}

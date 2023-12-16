<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'batch_no',
        'category',
        'unit',
        'p_date',
        'p_price',
        'sale_price',
    ];
}

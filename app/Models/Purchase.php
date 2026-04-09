<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsStockMovements;

class Purchase extends Model
{
    use HasFactory;

use RecordsStockMovements;
    protected $fillable = [
        'product_name',
        'quantity',
        'price',
        'supplier_name',
        'purchase_date',
    ];

    // Cast purchase_date to a Carbon instance automatically
    protected $casts = [
        'purchase_date' => 'date',
    ];
}
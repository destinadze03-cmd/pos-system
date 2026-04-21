<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsStockMovements;

class SaleItem extends Model
{
    use HasFactory;
 
use RecordsStockMovements;


    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

public function product()
    {
        return $this->belongsTo(Product::class);
    }

}


    

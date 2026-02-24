<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category_id', 'price', 'stock_quantity', 'barcode', 'description','image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Check if product has sufficient stock
    public function hasStock($quantity = 1)
    {
        return $this->stock_quantity >= $quantity;
    }

    // Reduce stock after sale
    public function reduceStock($quantity)
    {
        $this->decrement('stock_quantity', $quantity);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

}

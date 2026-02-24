<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'total_amount', 'amount_paid', 'change_amount', 'sale_date'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'sale_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    

public function products()
{
    return $this->belongsToMany(Product::class, 'sale_items')
                ->withPivot('quantity', 'unit_price', 'subtotal');
}

    
public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
public function items() {
    return $this->hasMany(SaleItem::class);
}

}

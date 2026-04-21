<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'type',
        'reference_id',
        'user_id',
        'action', // if you added action column in trait
    ];

    /**
     * Polymorphic parent (Product, SaleItem, Purchase, etc.)
     */
    public function movable()
    {
        /* Temporary fix for old lowercase records
        if ($this->type === 'saleitem') {
            $this->type = 'App\\Models\\SaleItem';
        }*/

        return $this->morphTo(null, 'type', 'reference_id')->withDefault();
    }

    /**
     * Product relationship
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * User who performed the action
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
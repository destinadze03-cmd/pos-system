<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
   
    protected $fillable = ['product_id', 'quantity', 'type', 'reference_id', 'user_id'];

    /**
     * Get the parent model (Product, Sale, Purchase, etc.)
     */
    public function movable()
    {
        // This maps your 'type' string to the actual Model class
        return $this->morphTo(null, 'type', 'reference_id')->withDefault();
    }

    /**
     * Relationship to the Product (if applicable)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relationship to the User who made the change
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
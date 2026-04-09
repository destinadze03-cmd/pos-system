<?php

namespace App\Traits;

use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;

trait RecordsStockMovements
{
    protected static function bootRecordsStockMovements()
{
    // Use 'deleting' to grab data while it still exists in the DB
    static::deleting(function ($model) {
        static::logMovement($model, 'deleted');
    });

    // Use 'created' and 'updated' as usual
    static::created(function ($model) { static::logMovement($model, 'created'); });
    static::updated(function ($model) { static::logMovement($model, 'updated'); });
}

protected static function logMovement($model, $event)
{
    if ($model instanceof \App\Models\StockMovement) return;

    $productId = ($model instanceof \App\Models\Product) ? $model->id : ($model->product_id ?? null);

    \App\Models\StockMovement::create([
        'user_id'      => auth()->id(),
        'action'       => $event,
        'reference_id' => $model->id,
        'type'         => strtolower(class_basename($model)),
        'quantity'     => $model->quantity ?? 0,
        'product_id'   => $productId, // Now works because database allows NULL
    ]);
}
}
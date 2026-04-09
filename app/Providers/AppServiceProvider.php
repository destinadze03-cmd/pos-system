<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
 use Illuminate\Database\Eloquent\Relations\Relation;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   









   

public function boot()
{
    Relation::enforceMorphMap([
        'product'   => 'App\Models\Product',
        'category'  => 'App\Models\Category',
        'sale'      => 'App\Models\Sale',
        'sale_item' => 'App\Models\SaleItem',
        'purchase'  => 'App\Models\Purchase',
        'stock_movement' => 'App\Models\StockMovement',
    ]);
}
}

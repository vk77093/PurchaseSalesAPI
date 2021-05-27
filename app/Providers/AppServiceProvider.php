<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Product;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
 /**
 * now we are doing the event if the product quantity is 0 then
 * the product automatically become unavailable
 * for that we need to go to app service provide and inside 
 * boot methods we need to define the values
 */
Product::updated(function ($product) {
if($product->quantity==0 && $product->isAvailable()){
    $product->status=Product::UNAVAILABLE_PRODUCT;
    $product->save();
}
});

    }
}

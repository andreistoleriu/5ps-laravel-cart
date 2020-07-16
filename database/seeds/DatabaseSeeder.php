<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Order;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 25)->create();
        factory(Order::class, 50)->create(); 

        $orders = Order::all();

        Product::all()->each(function ($product) use ($orders) { 
            $product->orders()->attach($orders->random(rand(2, 5))->pluck('id')->toArray(), 
            [
                'product_price' => $product->price,
            ]
            ); 
        });
    }
}

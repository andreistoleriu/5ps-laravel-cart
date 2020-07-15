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
        factory(Product::class, 10)->create()->each(function($u) {
            $u->orders()->save(factory(Order::class)->make());
        });

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

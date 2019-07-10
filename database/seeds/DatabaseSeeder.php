<?php

use App\User;
use App\Product;
use App\Category;
use App\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        $users_qty = 200;
        $categories_qty = 30;
        $products_qty = 1000;
        $transactions_qty = 1000;

        factory(User::class, $users_qty)->create();
        factory(Category::class, $categories_qty)->create();
        factory(Product::class, $products_qty)->create()->each(
            function ($product){
                $categories = Category::all()->random(mt_rand(1,5))->pluck('id');

                $product->categories()->attach($categories);
            });
        factory(Transaction::class, $transactions_qty)->create();

    }
}

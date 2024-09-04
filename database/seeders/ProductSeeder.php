<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        for ($i = 0; $i < 5; $i++) {

            $index = $i + 1;
            $product = new Product();

            $product->id = "PRODUCT-DUMMY-$index";
            $product->name = "Product-$index";
            $product->description = "Description-Product-$index";
            $product->category_id = "FOOD";
            $product->save();
        }
    }
}

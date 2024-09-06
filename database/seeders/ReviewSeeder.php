<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $review = new Review();
        $review->product_id = "PRODUCT-DUMMY-1";
        $review->customer_id = "SAMPLE";
        $review->rating = 5;
        $review->comment = "Rekomen buat yang lain. Pelayanannya bagus banget";
        $review->save();

        $review = new Review();
        $review->product_id = "PRODUCT-DUMMY-2";
        $review->customer_id = "SAMPLE";
        $review->rating = 4.5;
        $review->comment = "Rekomen. Pelayanannya bagus";
        $review->save();

        $review = new Review();
        $review->product_id = "PRODUCT-DUMMY-3";
        $review->customer_id = "SAMPLE";
        $review->rating = 4;
        $review->comment = "Lumayan. Pelayanannya Oke";
        $review->save();
    }
}

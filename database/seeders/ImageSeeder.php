<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $image1 = new Image();
        $image1->url = "https://www.programmerzamannow.com/images/1.jpg";
        $image1->imageable_id = "SAMPLE"; // references to table customerS with column id.
        $image1->imageable_type = "customer";
        $image1->save();

        $image1 = new Image();
        $image1->url = "https://www.programmerzamannow.com/images/2.jpg";
        $image1->imageable_id = "PRODUCT-DUMMY-2"; // references to table products with column id.
        $image1->imageable_type = "product";
        $image1->save();
    }
}

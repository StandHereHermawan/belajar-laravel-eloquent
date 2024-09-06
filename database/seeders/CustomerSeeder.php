<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $customer = new Customer();

        $customer->id = "SAMPLE";
        $customer->name = "Sample name";
        $customer->email = "sample@example.com";
        $customer->save();

        $customer = new Customer();
        
        $customer->id = "SAMPLE-2";
        $customer->name = "Sample name Again";
        $customer->email = "sampleAgain@example.com";
        $customer->save();
    }
}

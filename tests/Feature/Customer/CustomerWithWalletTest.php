<?php

namespace Tests\Feature\Customer;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Wallet;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CustomerWithWalletTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testQueryOneToOne(): void
    {
        $this->seed(CustomerSeeder::class);
        $this->seed(WalletSeeder::class);

        $customer = Customer::query()->find("SAMPLE");
        self::assertNotNull($customer);
        Log::info(json_encode($customer));

        $wallet = $customer->wallet;
        self::assertNotNull($wallet);
        Log::info(json_encode($customer));

        self::assertEquals(1000000, $wallet->amount);
    }

    public function testInsertRelationship()
    {

        $customer = new Customer();
        $customer->id = "TERRY";
        $customer->name = "Terry";
        $customer->email = "terry@racist.nigger";
        $customer->save();

        self::assertNotNull($customer);
        Log::info(json_encode($customer));

        $wallet = new Wallet();
        $wallet->amount = 1000000;

        $customer->wallet()->save($wallet);
        self::assertNotNull($wallet);
        Log::info(json_encode($wallet));
    }

    public function testSearchProduct()
    {
        self::seed(CategorySeeder::class);
        self::seed(ProductSeeder::class);

        $category = Category::query()->find('FOOD');
        self::assertNotNull($category);
        Log::info(json_encode($category));

        $outOfStockProducts = $category->products()->where('stock', '<=', 0)->get();

        self::assertNotNull($outOfStockProducts);
        self::assertCount(5, $outOfStockProducts);

        $outOfStockProducts->each(function ($product) {
            self::assertNotNull($product);
            Log::info(json_encode($product));
        });
    }
}

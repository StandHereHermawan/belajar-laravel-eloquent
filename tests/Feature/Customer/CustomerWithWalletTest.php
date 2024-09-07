<?php

namespace Tests\Feature\Customer;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Wallet;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ReviewSeeder;
use Database\Seeders\VirtualAccountSeeder;
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

    public function testHasOneThrough(): void
    {
        self::seed([CustomerSeeder::class, WalletSeeder::class, VirtualAccountSeeder::class]);

        $customer = Customer::query()->find("SAMPLE");
        self::assertNotNull($customer);
        Log::info(json_encode($customer));

        $virtualAccount = $customer->virtualAccount;
        Log::info(json_encode($virtualAccount));
        self::assertNotNull($virtualAccount);
        self::assertEquals("BCA", $virtualAccount->bank);
    }

    public function testHasManyThrough(): void
    {
        self::seed([CategorySeeder::class, ProductSeeder::class, CustomerSeeder::class, ReviewSeeder::class]);

        $category = Category::query()->find("FOOD");
        self::assertNotNull($category);
        Log::info(json_encode($category));

        $reviews = $category->reviews;
        self::assertNotNull($reviews);

        $reviews->each(function ($review) {
            self::assertNotNull($review);
            Log::info(json_encode($review));
        });

        self::assertCount(3, $reviews);
    }

    public function testManyToMany(): void
    {
        self::seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]);

        $customer = Customer::query()->find("SAMPLE");
        $customer->likeProducts()->attach("PRODUCT-DUMMY-1"); // attach productId

        for ($index = 2; $index <= 4; $index++) {
            $customer->likeProducts()->attach("PRODUCT-DUMMY-$index"); // attach productId
        }

        self::assertNotNull($customer);
    }

    public function testQueryManyToMany(): void
    {
        $this->testManyToMany();

        $customer = Customer::query()->find("SAMPLE");
        self::assertNotNull($customer);
        Log::info($customer);

        $products = $customer->likeProducts;
        self::assertNotNull($products);
        Log::info($products);

        self::assertCount(4, $products);
        self::assertEquals("PRODUCT-DUMMY-1", $products[0]->id);
        self::assertEquals("Product-1", $products[0]->name);

        $products->each(function ($product) {
            Log::info(json_encode($product));
        });
    }

    public function testRemoveManyToManyRelation(): void
    {
        $this->testQueryManyToMany();

        $customer = Customer::query()->find("SAMPLE");
        $customer->likeProducts()->detach("PRODUCT-DUMMY-2"); // detach productId

        $products = $customer->likeProducts;

        self::assertNotNull($products);
        self::assertCount(3, $products);

        $products->each(function ($product) {
            Log::info(json_encode($product));
        });
    }

    public function testPivotAttribute(): void
    {
        self::testQueryManyToMany();

        $customer = Customer::query()->find("SAMPLE");
        $products = $customer->likeProducts;

        foreach ($products as $product) {
            $pivot = $product->pivot;

            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);

            Log::info(json_encode($pivot));
        }
    }

    public function testConditionOnPivotAttribute(): void
    {
        self::testQueryManyToMany();

        $customer = Customer::query()->find("SAMPLE");
        $products = $customer->likeProductsLastWeek;

        foreach ($products as $product) {
            $pivot = $product->pivot;

            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);

            Log::info(json_encode($pivot));
        }
    }

    public function testPivotModel(): void
    {
        $this->testQueryManyToMany();

        $customer = Customer::query()->find("SAMPLE");
        $products = $customer->likeProducts;

        foreach ($products as $product) {

            Log::info(json_encode(null));

            $pivot = $product->pivot;
            self::assertNotNull($pivot);

            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);

            Log::info(json_encode($pivot));

            $customer = $pivot->customer;
            self::assertNotNull($customer);
            Log::info(json_encode($customer));

            $product = $pivot->product;
            self::assertNotNull($product);
            Log::info(json_encode($product));

            Log::info(json_encode(null));
        }
    }

    public function testOneToOnePolymorphism(): void
    {
        self::seed([CustomerSeeder::class, ImageSeeder::class]);

        $customer = Customer::query()->find("SAMPLE");
        self::assertNotNull($customer);
        Log::info(json_encode($customer));

        $image = $customer->image;
        self::assertNotNull($image);
        self::assertEquals("https://www.programmerzamannow.com/images/1.jpg", $image->url);
        Log::info(json_encode($customer));
    }
}

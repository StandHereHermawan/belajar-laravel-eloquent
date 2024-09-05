<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCategoryQuery(): void
    {
        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);

        $category = Category::query()->find('FOOD');

        self::assertNotNull($category);
        Log::info($category);

        // $products = Product::where("category_id", $category->id)->get();
        $products = $category->products;

        self::assertNotNull($products);
        self::assertCount(5, $products);
        Log::info($products);
    }

    public function testProductQuery(): void
    {
        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);

        $product = Product::query()->find('PRODUCT-DUMMY-1');

        self::assertNotNull($product);
        Log::info($product);

        $category = $product->products;

        self::assertNotNull($category);
        Log::info($category);
    }

    public function testManyProductQuery(): void
    {
        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);

        $products = Product::where('category_id', '=', 'FOOD')->get();

        self::assertNotNull($products);

        $products->each(function ($product) {
            Log::info(json_encode($product));
        });
        self::assertEquals(5, $products->count());
    }

    public function testHasOneOfMany()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);

        $category = Category::query()->find("FOOD");

        $cheapestProduct = $category->cheapestProduct;

        self::assertNotNull($cheapestProduct);
        self::assertEquals("PRODUCT-DUMMY-1", $cheapestProduct->id);

        $mostExpensiveProduct = $category->mostExpensiveProducts;
        self::assertNotNull($mostExpensiveProduct);
        self::assertEquals("PRODUCT-DUMMY-5", $mostExpensiveProduct->id);
    }
}

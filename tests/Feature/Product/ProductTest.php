<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\VoucherSeeder;
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

    public function testOneToOnePolymorphism(): void
    {
        self::seed([CategorySeeder::class, ProductSeeder::class, ImageSeeder::class]);

        $product = Product::query()->find("PRODUCT-DUMMY-2");
        self::assertNotNull($product);
        Log::info(json_encode($product));

        $image = $product->image;
        self::assertNotNull($image);
        self::assertEquals("https://www.programmerzamannow.com/images/2.jpg", $image->url);
        Log::info(json_encode($image));
    }

    public function testOneToManyPolymorphic(): void
    {
        self::seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class]);

        $product = Product::query()->first();
        self::assertNotNull($product);

        $comments = $product->comments;
        self::assertNotNull($comments);
        self::assertCount(1, $comments);

        foreach ($comments as $comment) {
            self::assertNotNull($comment);
            self::assertEquals(Product::class, $comment->commentable_type);
            self::assertEquals($product->id, $comment->commentable_id);
            Log::info("=========");
            Log::info(json_encode($comment));
            Log::info("=========");
        }
    }

    public function testOneOfManyPolymorphic(): void
    {
        self::seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class]);

        Log::info(json_encode("===== START SECTION ====="));

        $product = Product::query()->first();
        self::assertNotNull($product);
        Log::info(json_encode($product));

        $latestComment = $product->latestComment;
        self::assertNotNull($latestComment);
        Log::info(json_encode($latestComment));

        $oldestComment = $product->oldestComment;
        self::assertNotNull($oldestComment);
        Log::info(json_encode($oldestComment));

        Log::info(json_encode("===== END SECTION ====="));
    }
}

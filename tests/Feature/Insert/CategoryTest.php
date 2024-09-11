<?php

namespace Tests\Feature\Insert;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function testInsert(): void
    {
        $category = new Category();

        $category->id = "GADGET";
        $category->name = 'Gadget';

        $result = $category->save();
        self::assertTrue($result);

        for ($i = 0; $i < 5; $i++) {
            $category = new Category();

            $category->id = "DUMMY-" . ($i + 1);

            $category->name = "Category dummy " . ($i + 1);

            $result = $category->save();
            self::assertTrue($result);
        }

        $collection = DB::table("categories")->select()->get();
        self::assertNotNull($collection);
        self::assertCount(6, $collection);
    }

    public function testManyCategoryInsert(): void
    {
        $categories = [];

        for ($i = 1; $i <= 10; $i++) {
            $categories[] = [
                'id' => "Id-$i",
                'is_active' => true,
                'name' => "Name-$i",
            ];
        }

        // $result = Category::query()->insert($categories);
        $result = Category::insert($categories);

        self::assertTrue($result);

        $result = Category::query()->count();
        self::assertNotNull($result);
        self::assertEquals(10, $result);

        $collection = DB::table("categories")->select()->get();
        self::assertCount(10, $collection);
    }

    public function testQueryingRelations(): void
    {
        self::seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::query()->find("FOOD");
        $products = $category->products()->where('price', '<=', 7000)->get();

        self::assertNotNull($products);
        self::assertCount(3, $products);
        $products->each(function ($product) {
            Log::info(json_encode($product));
        });
    }

    public function testQueryingAggregateRelations(): void
    {
        self::seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::query()->find("FOOD");
        
        $products = $category->products()->where('price', '<=', 7000)->count();
        self::assertNotNull($products);
        self::assertEquals(3, $products);
        Log::info(json_encode($products));

        $productsTotal = $category->products()->count();
        self::assertNotNull($productsTotal);
        self::assertEquals(5, $productsTotal);
        Log::info(json_encode($productsTotal));
    }
}

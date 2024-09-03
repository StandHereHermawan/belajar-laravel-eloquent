<?php

namespace Tests\Feature\Insert;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
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
}

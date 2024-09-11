<?php

namespace Tests\Feature\Select;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategorySeederTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSelect(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $category = new Category();
            $category->id = "DUMMY-$i";
            $category->name = "Category dummy $i";
            $category->is_active = true;
            $category->save();
        }

        // $categories = Category::query()->whereNull("description")->get();
        $categories = Category::whereNull("description")->get();

        self::assertEquals(5, $categories->count());
        $categories->each(function ($category) {
            self::assertNull($category->description);
        });

        // $categories = Category::query()->whereNull("description")->get();
        $categories = Category::whereNull("description")->get();
        self::assertEquals(5, $categories->count());

        $categories->each(function ($category) {
            $category->description = "Category dummy description updated";
            $category->update();
        });
    }
}

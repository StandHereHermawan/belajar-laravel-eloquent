<?php

namespace Tests\Feature\Find;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategorySeederTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testFind(): void
    {
        $this->seed(CategorySeeder::class);

        // $category = Category::query()->find("FOOD");
        $category = Category::find("FOOD");

        self::assertNotNull($category);
        self::assertEquals("FOOD", $category->id);
        self::assertEquals("Food", $category->name);
        self::assertEquals("Food Category", $category->description);
    }
}

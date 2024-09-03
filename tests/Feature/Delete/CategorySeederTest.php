<?php

namespace Tests\Feature\Delete;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategorySeederTest extends TestCase
{
    public function testDelete(): void
    {
        self::seed(CategorySeeder::class);

        $category = Category::query()->find("FOOD");
        $result = $category->delete();

        self::assertTrue($result);

        $total = Category::count();
        self::assertEquals(0, $total);
    }
}

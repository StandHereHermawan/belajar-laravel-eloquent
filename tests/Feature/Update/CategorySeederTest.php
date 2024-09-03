<?php

namespace Tests\Feature\Update;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CategorySeederTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testUpdate(): void
    {
        $this->seed(CategorySeeder::class);

        // $category = Category::query()->find("FOOD");
        $category = Category::find("FOOD");

        $category->name = "Food Update";

        $result = $category->update();
        self::assertTrue($result);

        $categoryUpdate = Category::find("FOOD");
        Log::info(json_encode($categoryUpdate));
        self::assertEquals($category->name, $categoryUpdate->name);
    }
}

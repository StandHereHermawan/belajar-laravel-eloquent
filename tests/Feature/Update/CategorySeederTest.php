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

    function testManyUpdate()
    {

        $categories = [];

        for ($i = 1; $i <= 10; $i++) {
            # code...
            $categories[] = [
                'id' => "DUMMY-$i",
                'name' => "Category dummy $i"
            ];
        }

        $result = Category::query()->insert($categories);
        self::assertTrue($result);

        Category::query()->whereNull("description")->update([
            'description' => "Dummy description updated"
        ]);

        $total = Category::query()->where("description", "=", "Dummy description updated")->count();
        self::assertEquals(10, $total);
    }
}

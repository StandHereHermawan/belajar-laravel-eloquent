<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function testCreate(): void
    {
        $request = [
            'id' => "FOOD",
            'name' => "Food Category",
            'description' => "Food category from request"
        ];

        $category = new Category($request);
        $category->save();

        $request = [
            'id' => "FASHION",
            'name' => "Fashion Category",
            'description' => "Fashion category from request"
        ];

        // $category = Category::query()->create($request);
        $category = Category::create($request);

        self::assertNotNull($category->id);
    }

    public function testUpdate(): void
    {
        self::seed(CategorySeeder::class);

        $request = [
            'name' => "Food Category Updated",
            'description' => "Updated food category from request"
        ];

        $category = Category::find("FOOD");
        $category->fill($request);
        $result = $category->update();

        self::assertTrue($result);

        $category = Category::find("FOOD");
        self::assertEquals($request['name'], $category->name);
    }
}

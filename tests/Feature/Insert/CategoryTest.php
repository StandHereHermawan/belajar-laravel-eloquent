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
}

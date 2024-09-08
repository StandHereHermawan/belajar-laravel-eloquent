<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = Product::query()->first();
        $comment = new Comment();
        $comment->email = "sample@example.com";
        $comment->title = "Example Title 1";
        $comment->comment = "Example Comments on Product $product->id";
        $comment->commentable_id = $product->id;
        $comment->commentable_type = Product::class;
        $comment->save();

        $voucher = Voucher::query()->first();
        $comment2 = new Comment();
        $comment2->email = "sample2@example.com";
        $comment2->title = "Example Title 2";
        $comment2->comment = "Example Comments on Voucher $voucher->id";
        $comment2->commentable_id = $voucher->id;
        $comment2->commentable_type = Voucher::class;
        $comment2->save();
    }
}

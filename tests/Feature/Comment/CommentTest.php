<?php

namespace Tests\Feature\Comment;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CommentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM comments");
    }

    function testCreateComment(): void
    {
        $comment = new Comment();

        $comment->email = "example@proton.com";
        $comment->title = "Sample Title";
        $comment->comment = "Sample Comments";
        $comment->created_at = new \DateTime();
        $comment->updated_at = new \DateTime();
        $comment->save();

        self::assertNotNull($comment->id);

        $commentResults = Comment::find($comment->id);

        self::assertEquals($comment->id, $commentResults->id);
        self::assertEquals($comment->email, $commentResults->email);
        self::assertEquals($comment->title, $commentResults->title);
        self::assertEquals($comment->comment, $commentResults->comment);
    }

    function testUpdateComment(): void
    {
        $comment = new Comment();

        $comment->email = "example@proton.com";
        $comment->title = "Sample Title";
        $comment->comment = "Sample Comments";
        $comment->created_at = new \DateTime();
        $comment->updated_at = new \DateTime();
        $comment->save();

        self::assertNotNull($comment->id);

        $commentResults = Comment::find($comment->id);
        $commentResults->title = "Sample Title Updated";
        $commentResults->comment = "Sample Comments Updated";

        for ($i = 0; $i < 1000000; $i++) {
            # code...
            Log::info(json_encode("Wait list $i"));
        }

        $commentResults->update();

        $commentResultsAgain = Comment::find($commentResults->id);

        self::assertEquals($commentResultsAgain->id, $commentResults->id);
        self::assertEquals($commentResultsAgain->email, $commentResults->email);
        self::assertEquals($commentResultsAgain->title, $commentResults->title);
        self::assertEquals($commentResultsAgain->comment, $commentResults->comment);
    }

    function testDefaultAttributeValues(): void
    {
        $comment = new Comment();

        $comment->email = "sample@belajar.gwejh";
        $comment->created_at = new \DateTime();
        $comment->updated_at = new \DateTime();
        $comment->save();

        self::assertNotNull($comment->id);

        $result = Comment::find($comment->id);

        self::assertEquals($comment->id, $result->id);
    }
}

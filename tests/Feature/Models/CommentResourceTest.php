<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\Comment;
use App\Http\Resources\CommentResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class CommentResourceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_comment_resource_must_have_the_necessary_fields()
    {
        $comment = Comment::factory()->create();
        $commentResource = CommentResource::make($comment)->resolve();
        $this->assertEquals($comment->body, $commentResource['body']);
    }
}

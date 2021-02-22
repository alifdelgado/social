<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class CreateCommentsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
    */
    public function guest_users_cannot_create_comments()
    {
        $status = Status::factory()->create();
        $comment = ['body' => 'Mi primer comentario'];
        $response = $this->postJson(route('statuses.comments.store', $status), $comment);
        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function authenticated_users_can_comment_statuses()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $status = Status::factory()->create();
        $comment = ['body' => 'Mi primer comentario'];
        $response = $this->actingAs($user)->postJson(route('statuses.comments.store', $status), $comment);
        $response->assertJson([
            'data' => ['body' => $comment['body']]
        ]);
        $this->assertDatabaseHas('comments', [
            'user_id' =>  $user->id,
            'status_id' => $status->id,
            'body'  => $comment['body']
        ]);
    }
}

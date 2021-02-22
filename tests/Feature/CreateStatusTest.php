<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_users_can_not_create_statuses()
    {
        $response = $this->post(route('statuses.store'), ['body' => 'Mi primer status']);
        $response->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_can_create_statuses()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $body = 'Mi primer status';
        $response = $this->postJson(route('statuses.store'), ['body' => $body]);
        $response->assertJson([
            'data' => ['body'  =>  $body]
        ]);
        $this->assertDatabaseHas('statuses', [
            'user_id'   =>  $user->id,
            'body'      =>  $body
        ]);
    }

    /** @test */
    public function a_status_requires_a_body()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->postJson(route('statuses.store'), ['body' => '']);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message', 'errors' =>  ['body'],
        ]);
    }

    /** @test */
    public function a_status_body_requires_a_minimum_length()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->postJson(route('statuses.store'), ['body' => 'asdf']);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message', 'errors' =>  ['body'],
        ]);
    }
}

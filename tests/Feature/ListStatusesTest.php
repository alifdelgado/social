<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Status;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListStatusesTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function can_get_all_statuses()
    {
        $this->withoutExceptionHandling();
        $statuses0 = Status::factory()->create(['created_at' => now()->subDays(4)]);
        $statuses1 = Status::factory()->create(['created_at' => now()->subDays(3)]);
        $statuses2 = Status::factory()->create(['created_at' => now()->subDays(2)]);
        $statuses3 = Status::factory()->create(['created_at' => now()->subDays(1)]);
        $response = $this->getJson(route('statuses.index'));
        $response->assertSuccessful();
        $response->assertJson([
            'meta' => ['total' =>  4]
        ]);
        $response->assertJsonStructure(['data', 'links' => ['prev', 'next']]);
        $this->assertEquals(
            $statuses3->body,
            $response->json('data.0.body'),
        );
    }

    /** @test*/
    public function can_get_statuses_for_a_specific_user()
    {
        $user = User::factory()->create();
        $status1 = Status::factory()->create(['user_id' => $user->id, 'created_at' => now()->subDay()]);
        $status2 = Status::factory()->create(['user_id' => $user->id]);
        $otherStatuses = Status::factory(2)->create();
        $response = $this->actingAs($user)->getJson(route('users.statuses.index', $user));
        $response->assertJson([
            'meta' => ['total' => 2]
        ]);

        $response->assertJsonStructure([
            'data', 'links' => ['prev', 'next']
        ]);

        $this->assertEquals(
            $status2->body,
            $response->json('data.0.body')
        );
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
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
            'total' =>  4
        ]);
        $response->assertJsonStructure(['data', 'total', 'first_page_url', 'last_page_url']);
        $this->assertEquals(
            $statuses3->id,
            $response->json('data.0.id'),
        );
    }
}

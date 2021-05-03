<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanSeeProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function can_see_profiles()
    {
        $this->withoutExceptionHandling();
        User::factory()->create(['name'=>'Spike']);
        $this->get('@Spike')->assertSee('Spike');
    }
}

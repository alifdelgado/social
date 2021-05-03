<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Status;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function route_key_name_is_set_to_name()
    {
        $user = User::factory()->make();
        $this->assertEquals('name', $user->getRouteKeyName());
    }

    /** @test */
    public function user_has_a_link_to_their_profile()
    {
        $user = User::factory()->make();
        $this->assertEquals(route('users.show', $user), $user->link());
    }

    /** @test */
    public function user_has_an_avatar()
    {
        $user = User::factory()->make();
        $this->assertEquals('https://i.picsum.photos/id/724/200/300.jpg?hmac=MwcEnqDDOgKg6U3WYPytBPH_jurNEK2_2kcknpgP6wg', $user->avatar());
        $this->assertEquals('https://i.picsum.photos/id/724/200/300.jpg?hmac=MwcEnqDDOgKg6U3WYPytBPH_jurNEK2_2kcknpgP6wg', $user->avatar);
    }

    /** @test */
    public function a_user_has_many_statuses()
    {
        $user = User::factory()->create();
        Status::factory()->create(['user_id' => $user->id]);
        $this->assertInstanceOf(Status::class, $user->statuses()->first());
    }
}

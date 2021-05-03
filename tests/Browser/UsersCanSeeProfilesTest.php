<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Status;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanSeeProfilesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    public function users_can_see_profiles()
    {
        $user = User::factory()->create();
        $statuses = Status::factory(2)->create(['user_id' => $user->id]);
        $otherStatuses = Status::factory()->create();

        $this->browse(function(Browser $browser) use ($user, $statuses, $otherStatuses) {
            $browser->visit("/@{$user->name}")
                    ->assertSee($user->name)
                    ->waitForText($statuses->first()->body)
                    ->assertSee($statuses->first()->body)
                    ->assertSee($statuses->last()->body)
                    ->assertDontSee($otherStatuses->body)
                    ;
        });
    }
}

<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Status;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanSeeAllStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    public function users_can_see_all_statuses_on_the_homepage()
    {
        $user = User::factory()->create();
        $statuses = Status::factory(3)->create(['created_at' => now()->subMinute()]);
        $this->browse(function (Browser $browser) use ($statuses, $user) {
            $browser->loginAs($user)
                ->visit('/home')
                ->waitForText($statuses->first()->body);
            foreach($statuses as $status)
            {
                $browser->assertSee($status->body)
                        ->assertSee($status->user->name)
                        ->assertSee($status->created_at->diffForHumans());
            }
        });
    }
}

<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanCreateStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    public function users_can_create_statuses()
    {
        $user = User::factory()->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/home')
                ->type('body', 'Mi primer status')
                ->press('#create-status')
                ->screenshot('create-status')
                ->waitForText('Mi primer status')
                ->assertSee('Mi primer status')
                ->assertSee($user->name);
        });
    }
}

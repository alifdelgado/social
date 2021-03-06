<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanLoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
    */
    public function users_cannot_login_with_invalid_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', '')
                    ->press('#login-btn')
                    ->assertPathIs('/login')
                    ->assertPresent('#validation-errors')
                    ;
        });
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function registered_users_can_login()
    {
        $user = User::factory()->create(['email' => 'spike@spiegel.com']);
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'spike@spiegel.com')
                ->type('password', 'password')
                ->press('#login-btn')
                ->assertPathIs('/home')
                ->assertAuthenticated();
        });
    }
}

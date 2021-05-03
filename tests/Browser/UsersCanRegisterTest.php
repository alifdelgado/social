<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanRegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
    */
    public function users_cannot_register_with_invalid_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', '')
                    ->press('@register-btn')
                    ->assertPathIs('/register')
                    ->assertPresent('#validation-errors')
                    ;
        });
    }

    /**
     * @test
     * @throws \Throwable
    */
    public function users_can_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'SpikeSpiegel')
                    ->type('first_name', 'Spike')
                    ->type('last_name', 'Spiegel')
                    ->type('email', 'spike@spiegel.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('@register-btn')
                    ->assertPathIs('/home')
                    ->assertAuthenticated()
                    ;
        });
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_register()
    {
        $response = $this->post(route('register'), $this->userValidData());
        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'name'                  =>  'SpikeSpiegel2',
            'first_name'            =>  'Spike',
            'last_name'             =>  'Spiegel',
            'email'                 =>  'spike@spiegel.com',
        ]);

        $this->assertTrue(Hash::check('password', User::first()->password), 'The password must be encrypted');
    }

    /** @test */
    public function the_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => null])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => 1234])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => Str::random(61)])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => Str::random(2)])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_must_be_unique()
    {
        User::factory()->create(['name' => $this->userValidData()['name']]);
        $this->post(
            route('register'),
            $this->userValidData(['name' => $this->userValidData()['name']])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_may_only_contain_letters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => "{$this->userValidData()['name']} Black"])
        )->assertSessionHasErrors('name');

        $this->post(
            route('register'),
            $this->userValidData(['name' => "{$this->userValidData()['name']}<>"])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_first_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => null])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => 1234])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => Str::random(61)])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => Str::random(2)])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_may_only_contain_letters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => "{$this->userValidData()['first_name']}2"])
        )->assertSessionHasErrors('first_name');

        $this->post(
            route('register'),
            $this->userValidData(['first_name' => "{$this->userValidData()['first_name']}<>"])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_last_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => null])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => 1234])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => Str::random(61)])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => Str::random(2)])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_may_only_contain_letters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => "{$this->userValidData()['last_name']}2"])
        )->assertSessionHasErrors('last_name');

        $this->post(
            route('register'),
            $this->userValidData(['last_name' => "{$this->userValidData()['last_name']}<>"])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_email_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['email' => null])
        )->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_email_must_be_a_valid_email_address()
    {
        $this->post(
            route('register'),
            $this->userValidData(['email' => 'invalid@.com'])
        )->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_email_must_be_unique()
    {
        User::factory()->create(['email' => $this->userValidData()['email']]);
        $this->post(
            route('register'),
            $this->userValidData(['email' => $this->userValidData()['email']])
        )->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_password_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password' => null])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password' => 1234])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_at_least_6_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password' => Str::random(4)])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_confirmed()
    {
        $this->post(
            route('register'),
            $this->userValidData([
                'password' => 'password',
                'password_confirmation' => null
            ])
        )->assertSessionHasErrors('password');
    }

    /**
     * @return array
     */
    protected function userValidData($overrides = []): array
    {
        return array_merge([
            'name'                  =>  'SpikeSpiegel2',
            'first_name'            =>  'Spike',
            'last_name'             =>  'Spiegel',
            'email'                 =>  'spike@spiegel.com',
            'password'              =>  'password',
            'password_confirmation' =>  'password'
        ], $overrides);
    }
}

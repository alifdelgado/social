<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Comment;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanLikeCommentsTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    public function users_can_like_and_unlike_comments()
    {
        $user  = User::factory()->create();
        $comment = Comment::factory()->create();
        $this->browse(function (Browser $browser) use ($user, $comment) {
            $browser->loginAs($user)
                    ->visit('/home')
                    ->waitForText($comment->body)
                    ->assertSeeIn('@comment-likes-count', 0)
                    ->press('@comment-like-btn')
                    ->waitForText('Te gusta')
                    ->assertSee('Te gusta')
                    ->assertSeeIn('@comment-likes-count', 1)
                    ->press('@comment-like-btn')
                    ->waitForText('Me gusta')
                    ->assertSee('Me gusta')
                    ->assertSeeIn('@comment-likes-count', 0)
                    ;
        });
    }
}

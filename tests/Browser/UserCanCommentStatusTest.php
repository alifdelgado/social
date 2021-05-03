<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Status;
use App\Models\Comment;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCanCommentStatusTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function users_can_see_all_comments()
    {
        $user = User::factory()->create();
        $status = Status::factory()->create();
        $comments = Comment::factory(2)->create();

        $this->browse(function (Browser $browser) use ($user, $status, $comments) {
            $browser->loginAs($user)
                    ->visit('/home')
                    ->waitForText($status->body)
                    ;
                foreach($comments as $comment)
                {
                    $browser->assertSee($comment->body)
                            ->assertSee($comment->user->name);
                }
        });
    }

    /**
     * @test
     */
    public function authenticated_users_can_comment_statuses()
    {
        $user = User::factory()->create();
        $status = Status::factory()->create();
        $this->browse(function (Browser $browser) use ($status, $user) {
            $comment = 'Mi primer comentario';
            $browser->loginAs($user)
                    ->visit('/home')
                    ->waitForText($status->body)
                    ->type('comment', $comment)
                    ->press('@comment-btn')
                    ->waitForText($comment)
                    ->assertSee($comment)
                    ;
        });
    }
}

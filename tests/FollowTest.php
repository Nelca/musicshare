<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class FollowTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = factory(User::class)->create();
        $userId = 1;
        $this->actingAs($user)
             ->visit('/user/' . $userId)
             ->press('follow-button-' . $userId)
             ->see('unfollow-button-' . $userId);
    }
}

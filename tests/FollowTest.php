<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class FollowTest extends TestCase
{
    use DatabaseTransactions;

    public function testExample()
    {
        $user = factory(User::class)->create();
        $userId = 1;
        $this->actingAs($user)
             ->visit('/user/' . $userId)
             ->press('follow-button-' . $userId)
             ->see('unfollow-button-' . $userId);
    }

    public function testFollowView()
    {
        $user = factory(User::class)->create();
        $followUser = User::orderBy('created_at', 'asc')->first();
        $followUserId = $followUser->id;
        $followUserName = $followUser->name;
        $this->actingAs($user)
             ->visit('/user/' . $followUserId)
             ->press('follow-button-' . $followUserId)
             ->seeInDatabase('follows',[
                 'user_id' => $user->id
                 , 'follow_user_id' => $followUserId
             ])
             ->visit('/user/' . $user->id)
             ->click('1 Follow')
             ->see($followUserName);
    }


    public function testFollowerView()
    {
        $user = factory(User::class)->create();
        $followUser = User::orderBy('created_at', 'asc')->first();
        $followUserId = $followUser->id;
        $followUserName = $followUser->name;
        $this->actingAs($user)
             ->visit('/user/' . $followUserId)
             ->press('follow-button-' . $followUserId)
             ->seeInDatabase('follows',[
                 'user_id' => $user->id
                 , 'follow_user_id' => $followUserId
             ]);
    }

}

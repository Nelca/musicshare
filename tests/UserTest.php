<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class UserTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUsers()
    {
        $this->visit('/users/')
            ->see('Playlists')
            ->see('Favorites')
            ->see('User List');
    }

    public function testUserLink()
    {
        $user = factory(User::class)->create();
        $this->visit('/users/')
             ->click($user->name)
             ->seePageIs('/user/' . $user->id);
    }

    public function testUsersPageWithPlFav()
    {
        $user = factory(User::class)->create();
        $playlistName = "testPlayList";
        $favName = "favoriteTest";
        $favUrl = "https://www.youtube.com/watch?v=ZABXtVxyJwg&t=137s";
        $this->actingAs($user)
             ->visit('/playlists')
             ->type($playlistName, 'name')
             ->press('Add Playlist')
             ->visit('/favorites')
             ->type($favName, 'name')
             ->type($favUrl, 'url')
             ->press('Add Favorite')
             ->visit('/users/')
             ->see('has-playlist-'. $user->id . '-1')
             ->see('has-favorite-'. $user->id . '-1');
    }

    public function testUserPage()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('/user/' . $user->id)
             ->see($user->name);
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
             ])
             ->visit('/user/' . $followUserId)
             ->click('1 Follower')
             ->see($user->name);
    }

    public function testUserPageWithPlFav()
    {
        $user = factory(User::class)->create();
        $playlistName = "testPlayList";
        $favName = "favoriteTest";
        $favUrl = "https://www.youtube.com/watch?v=ZABXtVxyJwg&t=137s";
        $this->actingAs($user)
             ->visit('/playlists')
             ->type($playlistName, 'name')
             ->press('Add Playlist')
             ->visit('/favorites')
             ->type($favName, 'name')
             ->type($favUrl, 'url')
             ->press('Add Favorite')
             ->visit('/user/' . $user->id)
             ->see($playlistName)
             ->see($favName);
    }
}

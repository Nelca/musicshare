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
             ->seePageIs('/user/' . $user->id)
             ->see($user->name);
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

<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Playlist;

class PlaylistTest extends TestCase
{
    use DatabaseTransactions;

    public function testViewPlaylists()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit('/playlists/')
            ->see('New Playlist');
    }

    public function testAddPlaylist()
    {
        $user = factory(User::class)->create();
        $playlist = new Playlist;
        $playlist->name = "test list";
        $this->actingAs($user)
             ->visit('/playlists')
             ->type($playlist->name, 'name')
             ->press('Add Playlist')
             ->seePageIs('/playlists')
             ->see($playlist->name);

        $playlist = Playlist::where('name', $playlist->name)->first();
        $this->afterTestBlankPlaylist($playlist);
        $this->afterTestPlalylistLikeUnlike($playlist);
        return $playlist;
    }

    /*
    * @depends testAddPlaylist
    */
    public function afterTestBlankPlaylist(Playlist $playlist)
    {
        $user = factory(User::class)->create();
        $playlistId = $playlist->id;
        $this->visit('/playlists/')
             ->press('view-playlist-songs-' . $playlistId)
             ->seePageIs('/playlist/' . $playlistId . '/songs');
    }

    /*
    * @depends testAddPlaylist
    */
    public function afterTestPlalylistLikeUnlike (Playlist $playlist) 
    {
        $user = factory(User::class)->create();
        $playlistId = $playlist->id;
        $this->actingAs($user)
             ->visit('/playlists')
             ->press('like-playlist-' . $playlistId)
             ->seeInDatabase('evaluates',[
                 'user_id' => $user->id
                 , 'evaluation' => 1
                 , 'evaluatable_id' => $playlistId 
                 , 'evaluatable_type' => 'playlists'
             ]);
    }

    public function testMyPlaylists()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit('my-playlists')
            ->see('There is nothing yet.');
    }


}

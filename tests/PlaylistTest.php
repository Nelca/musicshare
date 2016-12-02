<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class PlaylistTest extends TestCase
{
    use DatabaseTransactions;

    public function testViewPlaylists()
    {
        $user = factory(User::class)->create();
        
        $this->visit('/playlists/')
            ->see('New Playlist');
    }

    public function testBlankPlaylist()
    {
        $user = factory(User::class)->create();
        $playlistId = 12;
        $this->visit('/playlists/')
             ->press('view-playlist-songs-' . $playlistId)
             ->seePageIs('/playlist/' . $playlistId . '/songs');
    }

    public function testAddPlaylist()
    {
        $user = factory(User::class)->create();
        $playlistName = "test list";
        $this->actingAs($user)
             ->visit('/playlists')
             ->type($playlistName, 'name')
             ->press('Add Playlist')
             ->seePageIs('/playlists');
        $this->actingAs($user)
             ->visit('/playlists')
             ->see($playlistName);
    }

    public function testPlalylistLikeUnlike () 
    {
        $user = factory(User::class)->create();
        $playlistId = 12;
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


}

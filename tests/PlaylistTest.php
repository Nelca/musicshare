<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class PlaylistTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

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

    public function testViewAuthor()
    {
        //$this->visit('/playlists')
	    // ->click('minato')
	    // ->seePageIs('/user/1');
    }


}

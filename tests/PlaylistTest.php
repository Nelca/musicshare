<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class PlaylistTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testViewPlaylistsUser()
    {
        //$user = factory(User::class)->create();

        //$this->actingAs($user)
	    // ->visit('/playlists')
	    // ->see('Current Playlists');
    }

    public function testBlankPlaylist()
    {
        //$user = factory(User::class)->create();

        //$this->actingAs($user)
	    // ->visit('/playlists')
	    // ->press('Add Playlist')
	    // ->see('name field is required');
    }

    public function testViewAuthor()
    {
        $this->visit('/playlists')
	     ->click('minato')
	     ->seePageIs('/user/1');
    }


}

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
        $user = factory(User::class)->create();

	$this->actingAs($user)
	     ->visit('/playlists')
	     ->see('Current Playlists');
    }

    public function testViewSongs()
    {
        $user = factory(User::class)->create();

	$this->actingAs($user)
	     ->visit('/playlists')
	     ->press('View Songs')
	     ->seePageIs('/playlist/1/songs');
    }

    public function testBlankPlaylist()
    {
        $user = factory(User::class)->create();

	$this->actingAs($user)
	     ->visit('/playlists')
	     ->press('Add Playlist')
	     ->see('name field is required');
    }

    public function testAddPlaylist()
    {
        $user = factory(User::class)->create();
	$insertPlaylistName = 'unit test';

	$this->actingAs($user)
	     ->visit('/playlists')
	     ->type($insertPlaylistName, 'name')
	     ->press('Add Playlist')
	     ->see($insertPlaylistName);
    }
}

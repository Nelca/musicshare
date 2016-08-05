<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
        $user = factory(App\User::class)->create();

	$this->actingAs($user)
	     ->visit('/playlists')
	     ->see('Current Playlists');
    }
}

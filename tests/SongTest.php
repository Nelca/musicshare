<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class SongTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddSongWithName()
    {
        $songName = "song test";
        $songUrl = "https://www.youtube.com/watch?v=ZABXtVxyJwg&t=137s";
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('/playlists')
             ->press('View Songs')
             ->type($songUrl, 'url')
             ->type($songName, 'name')
             ->press('Add Song')
             ->see($songName);
    }
}

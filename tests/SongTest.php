<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Playlist;
use App\Song;
//use Youtube;

class SongTest extends TestCase
{
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

    public function testAddSongWithoutName()
    {
        $user = factory(User::class)->create();

        $songKey = 'ZABXtVxyJwg&t=137s';
        //$songData = Youtube::getVideoInfo($songKey);
        //$songName = $songData->snippet->title; 
        $songUrl = "https://www.youtube.com/watch?v=" . $songKey;

        $this->actingAs($user)
             ->visit('/playlists')
             ->press('View Songs')
             ->type($songUrl, 'url')
             ->press('Add Song');
    }

    public function testSongLikeUnlike()
    {
        $user = factory(User::class)->create();
        $uid = $user->id;

        $playlist = Playlist::create([
            'name' => 'test_playlist'
            , 'user_id' => $uid 
        ]);
        $pid = $playlist->id;

        $song = Song::create([
            'playlist_id' => $pid
            , 'name' => 'test_song'
            , 'url' => 'https://www.youtube.com/watch?v=3FzNpto-jnU'
        ]);
        $sid = $song->id;

       $this->actingAs($user)
             ->visit('/playlist/' . $pid . '/songs')
             ->press('like-song-' . $sid)
             ->seeInDatabase('evaluates',[
                 'user_id' => $uid
                 , 'evaluation' => 1
                 , 'evaluatable_id' => $sid
                 , 'evaluatable_type' => 'songs'
             ]);
             
        $this->actingAs($user)
             ->visit('/playlist/' . $pid . '/songs')
             ->press('liked-song-' . $sid)
             ->seePageIs('/playlist/' . $pid . '/songs');

    }
}

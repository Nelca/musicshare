<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Playlist;
use App\Song;
//use Youtube;

class SongCheckTest extends TestCase
{
    use DatabaseTransactions;

    public function testDeleteSong()
    {
        $user = factory(User::class)->create();

        $songUrl = "https://www.youtube.com/watch?v=ZABXtVxyJwg";
        $playlist = $user->playlists()->create([
            'name' => 'test_playlist'
        ]);
        $pid = $playlist->id;
        $songName = 'test_song';
        $song = Song::create([
            'name' => $songName . '_' . $user->id
            , 'user_id' => $user->id 
            , 'playlist_id' => $pid
            , 'url' => $songUrl
        ]);

        $this->actingAs($user)
            ->visit('/playlist/' . $pid . '/songs')
            ->seeInDatabase('songs',[
                 'id' => $song->id
                 , 'name' => $song->name
                 , 'user_id' => $song->user_id
             ]);

            //->press('delete-song-' . $song->id)
            //->seePageIs('/playlist/' . $pid . '/songs');

    }
}

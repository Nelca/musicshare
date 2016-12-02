<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
//use Youtube;

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
        $this->actingAs($user)
             ->visit('/playlist/12/songs')
             ->press('like-song-28')
             ->seeInDatabase('evaluates',[
                 'user_id' => $user->id
                 , 'evaluation' => 1
                 , 'evaluatable_id' => 28
                 , 'evaluatable_type' => 'songs'
             ]);
             
        $this->actingAs($user)
             ->visit('/playlist/12/songs')
             ->press('liked-song-28')
             ->seePageIs('/playlist/12/songs');

    }
}

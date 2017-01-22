<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Song;
use App\Playlist;
use App\Evaluate;
use App\Repositories\SongRepository;
use App\Repositories\PlaylistRepository;
use Youtube;

class SongController extends Controller
{
    //
    protected $songs;

    public function __construct(SongRepository $songs, PlaylistRepository $playlists)
    {
        $this->songs = $songs;
        $this->playlists = $playlists;
    }

    public function index(Request $request, Playlist $playlist)
    {
        return view('songs.index', [
                'songs' => $playlist->songs,
                'playlist' => $playlist,
                ]);
    }

    public function mySongs (Request $request)
    {
        return view('songs.my-songs', [
                'songs' => $this->songs->forUser($request->user()),
                ]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
                'name' => 'max:255',
                'url' => 'required|url',
                ]);

        $playlist_id = $request->playlist_id;
        $url = $request->url;
        $song_key = $this->songs->setSongKey($url);

        if (empty($request->name)) {
            $song_data = Youtube::getVideoInfo($song_key);
            $song_name = $song_data->snippet->title;
        } else {
            $song_name = $request->name;
        }

        $song = new Song;
        $song->url = $url;
        $song->song_key =  $song_key;
        $song->name = $song_name;
        $song->user_id = $request->user()->id;

        $playlist = Playlist::find($playlist_id);
        $playlist->songs()->save($song);
        return redirect('/playlist/'. $playlist_id . '/songs');
    }

    public function destroyMySong(Request $request, Song $song)
    {
        $song->delete();
        return redirect('/my-songs');
    }

    public function destroy(Request $request, Song $song)
    {
        $song->delete();
        return redirect('/playlist/'. $request->playlist_id . '/songs');
    }

    public function like(Request $request, Song $song)
    {
        $like = new Evaluate;
        $like->user_id = $request->user()->id;
        $like->evaluation = 1;
        $song->evaluates()->save($like);
        if ($request->user()->oauth_token) {
            $this->songs->rateVideo($request->user(), $song, "like");
        }
 
        if ($request->playlist_id) {
            return redirect('/playlist/'. $request->playlist_id . '/songs');
        } else {
            return redirect('/my-songs');
        }
    }

    public function unLike(Request $request, Song $song)
    {
        $like = Evaluate::where('user_id', $request->user()->id)
                        ->where('evaluatable_type', 'songs')
                        ->where('evaluatable_id', $song->id)
                        ->get()->first();
        $like->delete();
        if ($request->user()->oauth_token) {
            $this->songs->rateVideo($request->user(), $song, "none");
        }

        if ($request->playlist_id) {
            return redirect('/playlist/'. $request->playlist_id . '/songs');
        } else {
            return redirect('/my-songs');
        }
    }
}

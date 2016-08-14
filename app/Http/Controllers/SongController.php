<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Song;
use App\Playlist;
use App\Evaluate;
use App\Repositories\SongRepository;
use App\Repositories\PlaylistRepository;

class SongController extends Controller
{
    //
    protected $songs;

    public function __construct(SongRepository $songs, PlaylistRepository $playlists)
    {
        $this->middleware('auth');
	$this->songs = $songs;
	$this->playlists = $playlists;
    }

    public function index(Request $request, $playlist_id)
    {
        $playlist = $this->playlists->currentPlaylist($playlist_id);
        return view('songs.index', [
	    'songs' => $this->songs->forPlaylist($playlist_id),
	    'playlist' => $playlist[0],
	]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
	    'name' => 'required|max:255',
	    'url' => 'required|url',
	]);

	$playlist_id = $request->playlist_id;
	$url = $request->url;

	// urlからkey取得
	$url_query_str = parse_url($url, PHP_URL_QUERY);
	parse_str($url_query_str, $url_querys);

	$song = new Song;
	$song->name = $request->name;
	$song->url = $url;
	$song_key = "";
	if (isset($url_querys['v'])) {
	    $song_key = $url_querys['v'];
	}
	$song->song_key =  $song_key;

	$playlist = Playlist::find($playlist_id);
	$playlist->songs()->save($song);

	return redirect('/playlist/'. $playlist_id . '/songs');
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
	return redirect('/playlist/'. $request->playlist_id . '/songs');
    }
}

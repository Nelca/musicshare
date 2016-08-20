<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Song;
use App\Playlist;
use App\Evaluate;
use App\Repositories\SongRepository;
use App\Repositories\PlaylistRepository;
use Config;

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

    public function index(Request $request, Playlist $playlist)
    {
        return view('songs.index', [
	    'songs' => $playlist->songs,
	    'playlist' => $playlist,
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

	// urlからkey取得
	$url_query_str = parse_url($url, PHP_URL_QUERY);
	parse_str($url_query_str, $url_querys);
        $song_key = "";
	if (isset($url_querys['v'])) {
	    $song_key = $url_querys['v'];
	}

	$youtube_json = file_get_contents(Config::get('const.youtube_api_url_pre') . $song_key . Config::get('const.youtube_api_url_param') . env('YOUTUBE_API_KEY') . Config::get('const.youtube_api_url_suf'));

        $youtube_props = json_decode($youtube_json);

	$song_name = $youtube_props->items[0]->snippet->title;

	$song = new Song;
	$song->url = $url;
	$song->song_key =  $song_key;
	$song->name = $song_name;
	
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Song;
use App\Playlist;
use App\Repositories\SongRepository;

class SongController extends Controller
{
    //
    protected $songs;

    public function __construct(SongRepository $songs)
    {
        $this->middleware('auth');
	$this->songs = $songs;
    }

    public function index(Request $request, $playlist)
    {
        return view('songs.index', [
	    'songs' => $this->songs->forPlaylist($playlist),
	    'playlist' => $playlist,
	]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
	    'name' => 'required|max:255',
	    'url' => 'required|url',

	]);

	$playlist = $request->playlist;

	$song = new Song;
	$song->playlist_id = $playlist;
	$song->name = $request->name;
	$song->url = $request->url;
	$song->save();

	return redirect('/playlist/'. $playlist . '/songs');
    }

    public function destroy(Request $request, Song $song)
    {
	$song->delete();
	return redirect('/playlist/'. $request->playlist . '/songs');
    }

    public function like(Request $request, Song $song)
    {
        $this->songs->updateLike($song, $request->like);

	return redirect('/playlist/'. $request->playlist . '/songs');
    }
}

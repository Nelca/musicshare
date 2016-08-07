<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Playlist;
use App\Repositories\PlaylistRepository;

class PlaylistController extends Controller
{
    //
    protected $playlists;

    public function __construct(PlaylistRepository $playlists)
    {
        $this->middleware('auth');
	$this->playlists = $playlists;
    }

    public function index(Request $request)
    {
        return view('playlists.index', [
	    'playlists' => $this->playlists->all($request->user()),
	]);
    }


    public function myPlaylists(Request $request)
    {
        return view('playlists.index', [
	    'playlists' => $this->playlists->forUser($request->user()),
	]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
	    'name' => 'required|max:255',
	]);

	$request->user()->playlists()->create([
	    'name' => $request->name,
	]);

	return redirect('/playlists');
    }

    public function destroy(Request $request, Playlist $playlist)
    {
	$playlist->delete();

	return redirect('/playlists');
    }
}


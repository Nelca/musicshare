<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Playlist;
use App\Evaluate;
use App\Repositories\PlaylistRepository;

class PlaylistController extends \App\Http\Controllers\Controller
{
    //
    protected $playlists;

    public function __construct(PlaylistRepository $playlists)
    {
	$this->playlists = $playlists;
    }

    public function index(Request $request)
    {
        return view('playlists.index', [
	    'playlists' => $this->playlists->all(),
	]);
    }

    public function apiIndex(Request $request)
    {
	return response()->json([
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

	return response('playlist stored');
    }

    public function destroy(Request $request, Playlist $playlist)
    {
	$playlist->delete();

	return redirect('/playlists');
    }

    public function update (Request $request, Playlist $playlist)
    {
        $playlist->name = $request->name;
	$playlist->save();
	return redirect('/playlists');
    }

    public function like(Request $request, Playlist $playlist)
    {
        $like = new Evaluate;
	$like->user_id = $request->user()->id;
	$like->evaluation = 1;
        $playlist->evaluates()->save($like);
	return redirect('/playlists');
    }
}


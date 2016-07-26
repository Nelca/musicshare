<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Song;
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

    public function index(Request $request)
    {
        return view('songs.index', [
	    'songs' => $this->songs->forPlaylist($request->playlist()),
	]);
    }

    public function sotre(Request $request)
    {
        $this->validate($request, [
	    'name' => 'required|max:255',
	]);

	$request->playlist()->songs()->create([
	    'name' => $request->name,
	]);

	return redirect('/songs');
    }
}

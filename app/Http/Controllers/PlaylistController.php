<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Playlist;
use App\Evaluate;
use App\Repositories\PlaylistRepository;

class PlaylistController extends Controller
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
                    'isMyPlaylistPage' => false,
                ]);
    }

    public function myPlaylists(Request $request)
    {
        return view('playlists.index', [
                    'playlists' => $this->playlists->forUser($request->user()),
                    'isMyPlaylistPage' => true,
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

        if ($request->isMyPlaylistPage) {
            return redirect('/my-playlists');
        } else {
            return redirect('/playlists');
        }
    }

    public function destroy(Request $request, Playlist $playlist)
    {
        $playlist->delete();

        if ($request->isMyPlaylistPage) {
            return redirect('/my-playlists');
        } else {
            return redirect('/playlists');
        }
        
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
 
        if ($request->isMyPlaylistPage) {
            return redirect('/my-playlists');
        } else {
            return redirect('/playlists');
        }
    }

    public function unLike(Request $request, Playlist $playlist)
    {
        $like = Evaluate::where('user_id', $request->user()->id)
                        ->where('evaluatable_type', 'playlists')
                        ->where('evaluatable_id', $playlist->id)
                        ->get()->first();
        $like->delete();
  
        if ($request->isMyPlaylistPage) {
            return redirect('/my-playlists');
        } else {
            return redirect('/playlists');
        }
    }

}


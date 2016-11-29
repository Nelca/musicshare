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

        // urlからkey取得
        $url_query_str = parse_url($url, PHP_URL_QUERY);
        parse_str($url_query_str, $url_querys);
        $song_key = "";
        if (isset($url_querys['v'])) {
            $song_key = $url_querys['v'];
        }

        $song_data = Youtube::getVideoInfo($song_key);
        $song_name = $song_data->snippet->title;
        if ($request->name) {
            $song_name = $request->name;
        } else {
            $song_name = $song_data->snippet->title;
        }

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
        if ($request->user()->oauth_token) {
            $this->rateVideo($request->user(), $song, "like");
        }
        return redirect('/playlist/'. $request->playlist_id . '/songs');
    }

    public function unLike(Request $request, Song $song)
    {
        $like = Evaluate::where('user_id', $request->user()->id)
                        ->where('evaluatable_type', 'songs')
                        ->where('evaluatable_id', $song->id)
                        ->get()->first();
        $like->delete();
        if ($request->user()->oauth_token) {
            $this->rateVideo($request->user(), $song, "none");
        }

        if ($request->playlist_id) {
            return redirect('/playlist/'. $request->playlist_id . '/songs');
        } else {
            return redirect('/mypage');
        }
    }

    public function rateVideo($user, $song, $rate)
    {
        $token = $user->oauth_token;
        $base_url = "https://www.googleapis.com/youtube/v3/videos/rate?";
        $base_url .= "rating=" . $rate;
        $base_url .= "&id=" . $song->song_key;
        $base_url .= "&access_token=" . $token;
        $query = array();
        $query = http_build_query($query, "", "&");
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            "Content-Length: ".strlen($query)
        );
        $context = array(
            'http' => array(
                'method' => 'POST',
                'header' => implode("\r\n", $header),
                'content' => $query
            )
        );
        $context = stream_context_create($context);
        $response = file_get_contents($base_url, false, $context);
        return $response;
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Favorite;
use App\Repositories\FavoriteRepository;
use Youtube;

class FavoriteController extends \App\Http\Controllers\Controller
{
    //
    protected $favorites;

    public function __construct(FavoriteRepository $favorites)
    {
        $this->middleware('auth');

	$this->favorites = $favorites;
    }

    public function index(Request $request)
    {
        return view('favorites.index', [
	    'favorites' => $this->favorites->forUser($request->user()),
	]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
	    'name' => 'max:255',
	    'url' => 'required|url',
	]);
	
	if ($request->name) {
	    $song_name = $request->name;
	} else {
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
	}

	$request->user()->favorites()->create([
	    'name' => $song_name,
	    'url' => $request->url,
	]);

	return redirect('/favorites');
    }

    public function destroy(Request $request, Favorite $favorite)
    {
        $this->authorize('destroy', $favorite);

	$favorite->delete();

	return redirect('/favorites');
    }
}

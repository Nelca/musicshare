<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Favorite;
use App\Repositories\FavoriteRepository;
use Youtube;

class FavoriteController extends Controller
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

	$create_favorite = new Favorite();
	$create_favorite->name = $song_name;
	$create_favorite->url = $request->url;
	$create_favorite->song_key = $song_key;

	$request->user()->favorites()->save($create_favorite);

	return redirect('/favorites');
    }

    public function destroy(Request $request, Favorite $favorite)
    {
        $this->authorize('destroy', $favorite);

	$favorite->delete();

	return redirect('/favorites');
    }
}

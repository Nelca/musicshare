<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Favorite;
use App\Repositories\FavoriteRepository;

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
	    'name' => 'required|max:255',
	    'url' => 'required|url',
	]);

	$request->user()->favorites()->create([
	    'name' => $request->name,
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

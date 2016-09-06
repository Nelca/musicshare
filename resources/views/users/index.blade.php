@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                   User Info 
                </div>
                <div class="panel-body">
		    <div class="row">
		        <div class="col-xs-12 col-md-6">
			    {{ $user->name }}
			</div>
		        <div class="col-xs-12 col-md-6">
			    @if (in_array(Auth::user()->id, $follower))
			        Following
			    @else
			        <form action="{{url('follow/')}}" method="POST">
			            {{ csrf_field() }}
				    {{ method_field('POST') }}
				    <input type="hidden" name="follow_user_id" value="{{ $user->id }}">
				    <button type="submit" id="delete-playlist-{{ $user->id }}" class="btn btn-info fa fa-btn fa-user-plus"></button>
			        </form>
			    @endif
			</div>
		    </div>
               </div>
	       <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-users" aria-hidden="true"></i>Follow
		    </div>
                    <div class="panel-body">
		        <div class="row">
		            <div class="col-xs-12 col-md-6">
			        <a href="{{ url('user/' . $user->id . '/follow') }}">{{ count($follow) }}  Follow</a>
                            </div>
		            <div class="col-xs-12 col-md-6">
			        <a href="{{ url('user/' . $user->id . '/follower') }}">{{ count($follower) }}  Follower</a>
                            </div>
                        </div>
                    </div>
		</div>

            <!-- Current Playlist -->
            @if (count($playlists) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-list-ul" aria-hidden="true"></i>  {{ $user->name }} Playlists
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped playlist-table">
                            <thead>
                                <th>Playlist</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($playlists as $playlist)
                                    <tr>
                                        <td class="table-text"><div>{{ $playlist->name }}</div></td>
                                        <!-- Playlist Buttons -->
                                        <td>
					    <div class="row">
						    <div class="col-xs-12 col-md-6">
							<form action="{{url('playlist/' . $playlist->id . '/songs')}}" method="POST">
							    {{ csrf_field() }}
							    {{ method_field('GET') }}
							    <button type="submit" id="view-playlist-songs-{{ $playlist->id }}" class="btn btn-primary">
								<i class="fa fa-btn fa-music"></i>View Songs
							    </button>
							</form>
						    </div>
						    <div class="col-xs-12 col-md-6">
							<form action="{{url('playlist/' . $playlist->id)}}" method="POST">
							    {{ csrf_field() }}
							    {{ method_field('DELETE') }}
							    <button type="submit" id="delete-playlist-{{ $playlist->id }}" class="btn btn-warning fa fa-btn fa-trash">
							    </button>
							</form>
						    </div>
					    </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
		</div>
            @endif
           <!-- Current Favorite -->
            @if (count($favorites) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-heart" aria-hidden="true"></i>  {{ $user->name }} Favorites
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped favorite-table">
                            <thead>
                                <th>Favorite</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($favorites as $favorite)
                                    <tr>
                                        <td class="table-text"><div>{{ $favorite->name }}</div></td>
                                        <!-- Favorite Buttons -->
                                        <td>
					    <div class="row">
						    <div class="col-xs-12 col-md-6">
							<form action="{{url('favorite/' . $favorite->id . '/songs')}}" method="POST">
							    {{ csrf_field() }}
							    {{ method_field('GET') }}
							    <button type="submit" id="view-favorite-songs-{{ $favorite->id }}" class="btn btn-primary">
								<i class="fa fa-btn fa-music"></i>View Songs
							    </button>
							</form>
						    </div>
						    <div class="col-xs-12 col-md-6">
							<form action="{{url('favorite/' . $favorite->id)}}" method="POST">
							    {{ csrf_field() }}
							    {{ method_field('DELETE') }}
							    <button type="submit" id="delete-favorite-{{ $favorite->id }}" class="btn btn-warning fa fa-btn fa-trash">
							    </button>
							</form>
						    </div>
					    </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
		</div>
            @endif
        </div>
    </div>
@endsection

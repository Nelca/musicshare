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
		            @if (Auth::check())
                        @if (in_array(Auth::user()->id, $follower))
                            <form action="{{url('unfollow/')}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('POST') }}
                                <input type="hidden" name="follow_user_id" value="{{ $user->id }}">
                                <button type="submit" id="delete-playlist-{{ $user->id }}" class="btn btn-info fa fa-btn fa-user-times"></button>
                            </form>
                        @else
                            <form action="{{url('follow/')}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('POST') }}
                                <input type="hidden" name="follow_user_id" value="{{ $user->id }}">
                                <button type="submit" id="delete-playlist-{{ $user->id }}" class="btn fa fa-btn fa-user-plus"></button>
                            </form>
                        @endif
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
    <!-- youtube activity -->
    @if (count($youtube_datas) > 0)
        <div class="panel panel-default">
                <div class="panel-heading">
            youtube activity
                </div>
                <div class="panel-body">
                    <table class="table table-striped song-table">
                        <thead>
                <th>サムネイル</th>
                            <th>Song</th>
                            <th>URL</th>
                        </thead>
                        <tbody>
                            @foreach ($youtube_datas as $youtube_data)
                                <tr>
                    <td>
                    <img src="http://i.ytimg.com/vi/{{ $youtube_data->contentDetails->like->resourceId->videoId }}/default.jpg">
                </td>
                                    <td class="table-text"><div>{{ $youtube_data->snippet->title }}</div></td>
                                    <td class="table-text">
                    <a class="fa fa-youtube-play" href="https://www.youtube.com/watch?v={{ $youtube_data->contentDetails->like->resourceId->videoId }}" target="_blank">youtube</a>
                </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

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

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <!-- Like Songs -->
            @if (count($songs) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
		       Like Songs
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped song-table">
                            <thead>
			        <th>サムネイル</th>
                                <th>Song</th>
                                <th>URL</th>
                                <th>&nbsp;</th>
                                <th style="width: 80px;">&nbsp;</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($songs as $song)
                                    <tr>
				        <td>
					    <img src="http://i.ytimg.com/vi/{{ $song->song_key }}/default.jpg">
					</td>
                                        <td class="table-text"><div>{{ $song->name }}</div></td>
                                        <td class="table-text">
					    <a class="fa fa-youtube-play" href="{{ $song->url }}" target="_blank">youtube</a>
					</td>

                                        <!-- Song Like Button -->
                                        <td>
					    @can('like', $song)
                                                <form action="{{url('song/' . $song->id) . '/like'}}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('PUT') }}
                                                    <button type="submit" id="like-song-{{ $song->id }}" class="btn fa fa-star">
                                                        Like
                                                    </button>
			                            <input type="hidden" name="playlist_id" value="{{ $playlist->id }}">
                                                </form>
					    @else
					        <div>Liked</div>
					    @endcan
                                        </td>
                                        <td class="table-text">
                                        </td>

                                        <!-- Song Delete Button -->
                                        <td>
                                            <form action="{{url('song/' . $song->id)}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" id="delete-song-{{ $song->id }}" class="btn btn-warning fa fa-btn fa-trash">
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
	    <!-- Like Playlists -->
            @if (count($playlists) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
		       Like Playlists 
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped playlist-table">
                            <thead>
                                <th>Playlist</th>
                                <th>Autohr</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($playlists as $playlist)
                                    <tr>
                                        <td class="table-text"><div>{{ $playlist->name }}</div></td>
                                        <td>
					    <div class="row">
						    <div class="col-xs-12 col-md-3">
							<form action="{{url('playlist/' . $playlist->id . '/songs')}}" method="POST">
							    {{ csrf_field() }}
							    {{ method_field('GET') }}
							    <button type="submit" id="view-playlist-songs-{{ $playlist->id }}" class="btn btn-primary">
								<i class="fa fa-btn fa-music"></i>View Songs
							    </button>
							</form>
						    </div>
						    <div class="col-xs-12 col-md-2">
					                @can('like', $playlist)
							    <form action="{{url('playlist/' . $playlist->id . '/like')}}" method="POST">
							        {{ csrf_field() }}
		        					{{ method_field('PUT') }}
			        				<button type="submit" id="like-playlist-{{ $playlist->id }}" class="btn  fa fa-star">Like</button>
				         		    </form>
							@else
							    <span>Liked</span>
							@endcan
						    </div>
						    <div class="col-xs-12 col-md-1">
							<form action="{{url('playlist/' . $playlist->id)}}" method="POST">
							    {{ csrf_field() }}
							    {{ method_field('DELETE') }}
							    <button type="submit" id="delete-playlist-{{ $playlist->id }}" class="btn btn-warning fa fa-btn fa-trash">
							    </button>
							</form>
						    </div>
						    <div class="col-xs-12 col-md-6">
							<form action="{{url('playlist/' . $playlist->id)}}" method="POST">
							    {{ csrf_field() }}
							    {{ method_field('PUT') }}
							    <input type="text" name="name" placeholder="update list name">
							    <button type="submit" id="update-playlist-{{ $playlist->id }}" class="btn fa fa-btn fa-pencil">
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

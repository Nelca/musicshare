@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Song
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Favorite Form -->
		    <form action="{{ url('favorite') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Favorie Name -->
                        <div class="form-group">
                            <label for="favorie-name" class="col-sm-3 control-label">Favorite</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" id="favorite-name" class="form-control" value="{{ old('favorite') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="favorie-url" class="col-sm-3 control-label">URL</label>
                            <div class="col-sm-6">
                                <input type="text" name="url" id="favorite-url" class="form-control" value="{{ old('favorite') }}">
                            </div>
                        </div>

                        <!-- Add Favorite Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Favorite 
                                </button>
                            </div>
                        </div>
                    </form>
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
					    @if ($youtube_data->snippet->type == 'like')
					        <img src="http://i.ytimg.com/vi/{{ $youtube_data->contentDetails->like->resourceId->videoId }}/default.jpg">
					    @else ($youtube_data->snippet->type == 'playlistItem')
					        playlistItem
					    @endif
					</td>
                                        <td class="table-text"><div>{{ $youtube_data->snippet->title }}</div></td>
                                        <td class="table-text">
					    @if ($youtube_data->snippet->type == 'like')
					        <a class="fa fa-youtube-play" href="https://www.youtube.com/watch?v={{ $youtube_data->contentDetails->like->resourceId->videoId }}" target="_blank">youtube</a>
					    @else ($youtube_data->snippet->type == 'playlistItem')
					        playlistItem
					    @endif

					</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
	    <!-- Current Song -->
            @if (count($songs) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
		        TimeLine
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped song-table">
                            <thead>
			        <th>サムネイル</th>
                                <th>Song</th>
                                <th>User</th>
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
					    <a class="fa fa-user" href="{{ url('/user/' . 1 ) }}" target="_blank">{{ $song->user_name }}</a>
					</td>
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
					    {{ $song->type}}
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
        </div>
    </div>
@endsection

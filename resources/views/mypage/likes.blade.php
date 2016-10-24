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
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                Playlist
                            </div>
                            <div class="col-xs-12 col-md-2">
                                Autohr
                            </div>
                            <div class="col-xs-12 col-md-5">
                                Actions 
                            </div>
                        </div>
                        @foreach ($playlists as $playlist)
                            <div class="row">
                                <div class="col-xs-12 col-md-5">
                                    {{ $playlist->name }}
                                </div>
                                <div class="col-xs-12 col-md-2">
                                    <a href="{{url('user/' . $playlist->user_id )}}"><span class="fa fa-user">{{ $playlist->user_name}}</span></a>
                                </div>
                                <div class="col-xs-12 col-md-5">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-8">
                                            <form action="{{url('playlist/' . $playlist->id . '/songs')}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('GET') }}
                                                <button type="submit" id="view-playlist-songs-{{ $playlist->id }}" class="btn btn-primary">
                                                    <i class="fa fa-btn fa-music"></i>View Songs
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-xs-12 col-md-4">
                                            @can('like', $playlist)
                                                <form action="{{url('playlist/' . $playlist->id . '/like')}}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('PUT') }}
                                                    <button type="submit" id="like-playlist-{{ $playlist->id }}" class="btn  fa fa-star"></button>
                                                </form>
                                            @else
                                                <form action="{{url('playlist/' . $playlist->id . '/unlike')}}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('PUT') }}
                                                    <button type="submit" id="like-playlist-{{ $playlist->id }}" class="btn btn-warning fa fa-star"></button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

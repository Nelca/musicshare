@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
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
                                <th>Like</th>
                                <th>Type</th>
                            </thead>
                            <tbody>
                                @foreach ($songs as $song)
                                    <tr>
                                        <td>
                                            <iframe width="120" height="90" src="https://www.youtube.com/embed/{{ $song->song_key }}" frameborder="0" allowfullscreen></iframe>
                                        </td>
                                        <td class="table-text">
                                            <a href="{{ $song->url }}" target="_blank">{{ $song->name }}</a>
                                        </td>
                                        <td class="table-text">
                                            <a class="fa fa-user" href="{{ url('/user/' . 1 ) }}" target="_blank">{{ $song->user_name }}</a>
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
                                                Liked
                                            @endcan
                                        </td>
                                        <td class="table-text">
                                            {{ $song->type}}
                                            @if ($song->type == "song") 
                                                <a class="fa fa-list-ul" href="{{ url('/playlist/' . $song->playlist_id . '/songs') }}">Playlist</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
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
        </div>
    </div>
@endsection

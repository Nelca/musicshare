@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <!-- Current Song -->
            @if (count($songs) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        MySongs
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped song-table">
                            <thead>
                                <th>サムネイル</th>
                                <th>Song</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>Playlist</th>
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
                                        <!-- Song Like Button -->
                                        <td>
                                            @can('like', $song)
                                                <form action="{{url('song/' . $song->id) . '/like'}}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('PUT') }}
                                                    <button type="submit" id="like-song-{{ $song->id }}" class="btn fa fa-star"></button>
                                                    <input type="hidden" name="playlist_id" value="{{ $song->playlist_id }}">
                                                </form>
                                            @else
                                                <form action="{{url('song/' . $song->id) . '/unlike'}}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('PUT') }}
                                                    <button type="submit" id="like-song-{{ $song->id }}" class="btn btn-warning fa fa-star">
                                                    </button>
                                                    <input type="hidden" name="playlist_id" value="{{ $song->playlist_id }}">
                                                </form>
                                            @endcan
                                        </td>
                                        <td class="table-text">
                                            <div>{{-- count($song->evaluates)--}}<span class="fa fa-star"></span></div>
                                        </td>
                                        <!-- Song Delete Button -->
                                        <td>
                                            <form action="{{url('song/' . $song->id)}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" id="delete-song-{{ $song->id }}" class="btn fa fa-btn fa-trash">
                                                </button>
                                                <input type="hidden" name="playlist_id" value="{{ $song->playlist_id }}">
                                            </form>
                                        </td>
                                        <td>
                                             <a class="btn btn-primary" href="{{url('playlist/' . $song->playlist_id . '/songs/')}}">
                                                 <i class="fa fa-list-ul"></i>
                                                 {{$song->playlist_name}}
                                             </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div>
                    There is nothing yet.
                </div>
            @endif
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Playlist
                </div>
                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')
                    <!-- New Task Form -->
                    <form action="{{ url('playlist') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="isMyPlaylistPage" value="{{$isMyPlaylistPage}}">
                        <!-- Playlist Name -->
                        <div class="form-group">
                            <label for="favorie-name" class="col-sm-3 control-label">Playlist</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" id="playlist-name" class="form-control" value="{{ old('playlist') }}">
                            </div>
                        </div>
                        <!-- Add Playlist Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Playlist 
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Playlist -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Current Playlists
                </div>
                @if (count($playlists) > 0)
                    {!! $playlists->render() !!}
                    <div class="panel-body">
                        <table class="table table-striped playlist-table">
                            <thead>
                                <th>Playlist</th>
                                <th>Author</th>
                                <th>Songs and Likes</th>
                            </thead>
                            <tbody>
                                @foreach ($playlists as $playlist)
                                    <tr>
                                        <td class="table-text"><div>{{ $playlist->name }}</div></td>
                                        <td>
                                            @if ($playlist->user)
                                                 <a href="{{url('user/' . $playlist->user->id )}}"><span class="fa fa-user">{{ $playlist->user->name}}</span></a>
                                            @endif
                                        </td>
                                        <!-- Playlist Buttons -->
                                        <td>
                                            <div class="row">
                                                <div class="col-xs-12 col-md-3">
                                                    <form action="{{url('playlist/' . $playlist->id . '/songs')}}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('GET') }}
                                                        <button type="submit" id="view-playlist-songs-{{ $playlist->id }}" class="btn btn-primary">
                                                        <i class="fa fa-btn fa-music"></i>{{ count($playlist->songs)}} Songs
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="col-xs-12 col-md-3">
                                                    @can('like', $playlist)
                                                        <form action="{{url('playlist/' . $playlist->id . '/like')}}" method="POST">
                                                            {{ csrf_field() }}
                                                            {{ method_field('PUT') }}
                                                            <input type="hidden" name="isMyPlaylistPage" value="{{$isMyPlaylistPage}}">
                                                            <button type="submit" id="like-playlist-{{ $playlist->id }}" class="btn fa fa-star"></button>
                                                        </form>
                                                    @else
                                                        @if (Auth::check())
                                                            <form action="{{url('playlist/' . $playlist->id . '/unlike')}}" method="POST">
                                                                {{ csrf_field() }}
                                                                {{ method_field('PUT') }}
                                                                <input type="hidden" name="isMyPlaylistPage" value="{{$isMyPlaylistPage}}">
                                                                <button type="submit" id="liked-playlist-{{ $playlist->id }}" class="btn btn-warning fa fa-star"></button>
                                                            </form>
                                                        @endif
                                                    @endcan
                                                </div>
                                                <div class="col-xs-12 col-md-3">
                                                    <span class="fa fa-star"></span><span>{{ count($playlist->evaluates) }}</span>likes
                                                </div>
                                                <div class="col-xs-12 col-md-3">
                                                    @can('destroy', $playlist)
                                                        <form action="{{url('playlist/' . $playlist->id)}}" method="POST">

                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <input type="hidden" name="isMyPlaylistPage" value="{{$isMyPlaylistPage}}">
                                                            <button type="submit" id="delete-playlist-{{ $playlist->id }}" class="btn fa fa-btn fa-trash">
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $playlists->render() !!}
                @else
                    <div>
                        There is nothing yet.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

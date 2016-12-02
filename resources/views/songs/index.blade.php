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

                    <!-- New Task Form -->
                    <form action="{{ url('song') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Song Name -->
                        <div class="form-group">
                            <label for="favorie-name" class="col-sm-3 control-label">Song</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" id="song-name" class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>

                        <!-- Song URL -->
                        <div class="form-group">
                            <label for="favorie-name" class="col-sm-3 control-label">URL</label>
                            <div class="col-sm-6">
                                <input type="text" name="url" id="song-url" class="form-control" value="{{ old('url') }}">
                            </div>
                        </div>
                        <!-- Add Song Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Song 
                                </button>
                            </div>
                        </div>
			<input type="hidden" name="playlist_id" value="{{ $playlist->id }}">
                    </form>
                </div>
            </div>

            <!-- Current Song -->
            @if (count($songs) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                       {{ $playlist->name }} 
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped song-table">
                            <thead>
                                <th>サムネイル</th>
                                <th>Song</th>
                                <th>&nbsp;</th>
                                <th style="width: 80px;">&nbsp;</th>
                                <th>&nbsp;</th>
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
                                                    <button type="submit" id="like-song-{{ $song->id }}" class="btn fa fa-star">
                                                    </button>
                                                    <input type="hidden" name="playlist_id" value="{{ $playlist->id }}">
                                                </form>
                                            @else
                                                <form action="{{url('song/' . $song->id) . '/unlike'}}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('PUT') }}
                                                    <button type="submit" id="liked-song-{{ $song->id }}" class="btn btn-warning fa fa-star">
                                                    </button>
                                                    <input type="hidden" name="playlist_id" value="{{ $playlist->id }}">
                                                </form>
                                            @endcan
                                        </td>
                                        <td class="table-text">
                                           <div>{{ count($song->evaluates)}}<span class="fa fa-star"></span></div>
                                        </td>
                                        <!-- Song Delete Button -->
                                        <td>
                                            <form action="{{url('song/' . $song->id)}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit" id="delete-song-{{ $song->id }}" class="btn fa fa-btn fa-trash">
                                                </button>
                                                <input type="hidden" name="playlist_id" value="{{ $playlist->id }}">
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

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
			<input type="hidden" name="playlist" value="{{ $playlist }}">
                    </form>
                </div>
            </div>

            <!-- Current Song -->
            @if (count($songs) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Songs
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
					    <div><a href="{{ $song->url }}" target="_blank">link</a></div>
					</td>

                                        <!-- Song Like Button -->
                                        <td>
                                            <form action="{{url('song/' . $song->id) . '/like'}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('PUT') }}

                                                <button type="submit" id="like-song-{{ $song->id }}" class="btn">
                                                    Like
                                                </button>
			                        <input type="hidden" name="playlist" value="{{ $playlist }}">
                                            </form>
                                        </td>
                                        <td class="table-text">
					   <div>{{ count($song->evaluates)}} Like!!</div>
                                        </td>

                                        <!-- Song Delete Button -->
                                        <td>
                                            <form action="{{url('song/' . $song->id)}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit" id="delete-song-{{ $song->id }}" class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i>Delete
                                                </button>
			                        <input type="hidden" name="playlist" value="{{ $playlist }}">
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

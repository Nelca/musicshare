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

                        <!-- Playlist Name -->
                        <div class="form-group">
                            <label for="favorie-name" class="col-sm-3 control-label">Playlist</label>

                            <div class="col-sm-6">
                                <input type="text" name="name" id="playlist-name" class="form-control" value="{{ old('playlist') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="favorie-url" class="col-sm-3 control-label">URL</label>

                            <div class="col-sm-6">
                                <input type="text" name="url" id="playlist-url" class="form-control" value="{{ old('playlist') }}">
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
            @if (count($playlists) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Playlists
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped playlist-table">
                            <thead>
                                <th>Playlist</th>
                                <th>URL</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($playlists as $playlist)
                                    <tr>
                                        <td class="table-text"><div>{{ $playlist->name }}</div></td>
                                        <td class="table-text"><div>{{ $playlist->url }}</div></td>

                                        <!-- Playlist Delete Button -->
                                        <td>
                                            <form action="{{url('playlist/' . $playlist->id)}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit" id="delete-playlist-{{ $playlist->id }}" class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i>Delete
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

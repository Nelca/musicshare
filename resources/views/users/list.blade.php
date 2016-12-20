@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                   User List 
                </div>
            <!-- Current Playlist -->
            @if (count($users) > 0)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table table-striped user-table">
                            <thead>
                                <th>User List</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="table-text">
                                            <a href="{{url('user/' . $user->id )}}"> <i class="fa fa-user" aria-hidden="true"></i> {{ $user->name }}</a>
                                        </td>
                                        <!-- Playlist Buttons -->
                                        <td id="has-playlist-{{$user->id}}-{{ count($user->playlists)}}">{{ count($user->playlists)}} <i class="fa fa-list-ul" aria-hidden="true"></i> Playlists</td>
                                        <td id="has-favorite-{{$user->id}}-{{ count($user->favorites)}}">{{ count($user->favorites)}} <i class="fa fa-heart" aria-hidden="true"></i> Favorites</td>
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

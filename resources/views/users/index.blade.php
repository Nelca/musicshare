@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                   User Info 
                </div>
                <div class="panel-body">
		    <div class="row">
		        <div class="">
			    {{ $user->name }}
			</div>
		    </div>
               </div>
            <!-- Current Playlist -->
            @if (count($playlists) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $user->name }} Playlists
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped playlist-table">
                            <thead>
                                <th>Playlist</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($playlists as $playlist)
                                    <tr>
                                        <td class="table-text"><div>{{ $playlist->name }}</div></td>
                                        <!-- Playlist Buttons -->
                                        <td>
					    <div class="row">
						    <div class="col-xs-12 col-md-6">
							<form action="{{url('playlist/' . $playlist->id . '/songs')}}" method="POST">
							    {{ csrf_field() }}
							    {{ method_field('GET') }}
							    <button type="submit" id="view-playlist-songs-{{ $playlist->id }}" class="btn btn-primary">
								<i class="fa fa-btn fa-music"></i>View Songs
							    </button>
							</form>
						    </div>
						    <div class="col-xs-12 col-md-6">
							<form action="{{url('playlist/' . $playlist->id)}}" method="POST">
							    {{ csrf_field() }}
							    {{ method_field('DELETE') }}
							    <button type="submit" id="delete-playlist-{{ $playlist->id }}" class="btn btn-warning fa fa-btn fa-trash">
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

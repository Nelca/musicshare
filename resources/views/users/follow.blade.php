@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                   Follow User List 
                </div>
            <!-- Current Playlist -->
            @if (count($follows) > 0)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table table-striped user-table">
                            <thead>
                                <th>Follow User List</th>
                            </thead>
                            <tbody>
                                @foreach ($follows as $user)
                                    <tr>
                                        <td class="table-text">
					    <a href="{{url('user/' . $user->id )}}"> <i class="fa fa-user" aria-hidden="true"></i> {{ $user->name }}</a>
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

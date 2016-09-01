@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Favorite
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Task Form -->
                    <form action="{{ url('favorite') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="favorie-name" class="col-sm-3 control-label">Favorite</label>

                            <div class="col-sm-6">
                                <input type="text" name="name" id="favorite-name" class="form-control" value="{{ old('favorite') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="favorie-url" class="col-sm-3 control-label">URL</label>

                            <div class="col-sm-6">
                                <input type="text" name="url" id="favorite-url" class="form-control" value="{{ old('favorite') }}">
                            </div>
                        </div>

                        <!-- Add Favorite Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Favorite 
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Favorite -->
            @if (count($favorites) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Favorites
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped favorite-table">
                            <thead>
                                <th>Favorite</th>
                                <th>URL</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($favorites as $favorite)
                                    <tr>
                                        <td class="table-text"><div>{{ $favorite->name }}</div></td>
                                        <td class="table-text"><div><a class="fa fa-youtube-play" href="{{ $favorite->url }}" target="_blank">youtube</a></div></td>
					                                            <!-- Favorite Delete Button -->
                                        <td>
                                            <form action="{{url('favorite/' . $favorite->id)}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit" id="delete-favorite-{{ $favorite->id }}" class="btn btn-danger">
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

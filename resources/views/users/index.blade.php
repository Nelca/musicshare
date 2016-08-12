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
        </div>
    </div>
@endsection

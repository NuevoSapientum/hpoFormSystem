@extends('layout.default')

@section('head')
	<h1>Edit Profile</h1>
@endsection

@section('content')
	<form method="POST" action="#">
		<input type="text" class="form-control" value="{{Auth::user()->emp_name}}"/>
		<input type="text" class="form-control" value="{{Auth::user()->emp_position}}"/>
	</form>
@endsection
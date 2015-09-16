@extends('layout.default')

@section('head')
	<h1>Edit Profile</h1>
@endsection

@section('content')
	@if (count($errors) > 0)
    <div class="alert alert-danger">
    There were some problems editing your profile:
    <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>
    @endif
	<form method="POST" action="{{URL::to('accounts/resetPassword/' . $user->id)}}">
		<input type="hidden" name="_token" value="{!! csrf_token() !!}">
		<label>New Password:</label>
		<input type="password" class="form-control" name="password" placeholder="New Password" value="{{old('password')}}" /><br/>
		<label>Confirm Password:</label>
		<input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" />
		<br/>
	<button type="submit" class="btn btn-primary">Save</button>
	</form>
@endsection
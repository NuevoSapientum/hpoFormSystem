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
	<form method="POST" action="{{URL::to('accounts/show/' . $user->id)}}">
		<input type="hidden" name="_token" value="{!! csrf_token() !!}">
		<label>Name:</label>
		<input type="text" class="form-control" name="name" value="{{$user->emp_name}}" /><br/>
		<label>Position:</label>
		<select class="form-control" name="position">
              @foreach($positions_all as $post)
                <option id="{{$post->position_id}}" value="{{$post->position_id}}">{{$post->position_name}}</option>
              @endforeach
        </select><br/>
        <label>Email:</label>
		<input type="text" class="form-control" name="email" value="{{$user->email}}" /><br/>
		<label>ID Number(<i>Username</i>):</label>
		<input type="number" name="username" class="form-control" value="{{$user->username}}" />
		<br/>
	<button type="submit" class="btn btn-primary confirm">Save</button>
	</form>

	<script type="text/javascript">
			document.getElementById('{{$user->position_id}}').selected = "true";
	</script>
@endsection
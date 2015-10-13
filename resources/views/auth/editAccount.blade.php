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
                <option id="{{$post->id}}" value="{{$post->id}}">{{$post->position_name}}</option>
              @endforeach
        </select><br/>
        <label>Email:</label>
		<input type="text" class="form-control" name="email" value="{{$user->email}}" /><br/>
		<label>ID Number:</label>
		<input type="number" name="username" class="form-control" value="{{$user->username}}" /><br/>
		<label>Permissioner:</label>
		<div class="radio">
			@if($user->permissioners == 1)
				<label><input type="radio" value="1" checked="checked" name="permissioners" />Supervisor |</label>
				<label><input type="radio" value="2" name="permissioners" />Project Manager |</label>
				<label><input type="radio" value="3" name="permissioners" />Company Representative</label>
			@elseif($user->permissioners == 2)
				<label><input type="radio" value="1" name="permissioners" />Supervisor |</label>
				<label><input type="radio" value="2" checked="checked" name="permissioners" />Project Manager |</label>
				<label><input type="radio" value="3" name="permissioners" />Company Representative</label>
			@elseif($user->permissioners == 3)
				<label><input type="radio" value="1" name="permissioners" />Supervisor |</label>
				<label><input type="radio" value="2" name="permissioners" />Project Manager |</label>
				<label><input type="radio" value="3" checked="checked" name="permissioners" />Company Representative</label>
			@else
				<input type="radio" value="0" hidden checked="checked" name="permissioners" >
				<label><input type="radio" value="1" name="permissioners" />Supervisor |</label>
				<label><input type="radio" value="2" name="permissioners" />Project Manager |</label>
				<label><input type="radio" value="3" name="permissioners" />Company Representative</label>
			@endif
		</div>
		<label>Entitlement:</label>
		<input type="number" name="entitlement" value="{{$user->entitlement}}" class="form-control" />
		<br/>
		<label>Days Taken:</label>
		<input type="number" name="days_taken" value="{{$user->days_taken}}" class="form-control" />
		<br/>
	<button type="submit" class="btn btn-primary confirm">Save</button>
	</form>

	<script type="text/javascript">
			document.getElementById('{{$user->position_id}}').selected = "true";
	</script>
@endsection
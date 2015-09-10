@extends('layout.default')

@section('head')
	<h1>Edit Profile</h1>
@endsection

@section('content')
	
	@if (count($errors) > 0)
    <div class="alert alert-danger">
    There were some problems creating an account:
    <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>
    @endif
	<form method="POST" action="{{URL::to('/editProfile')}}">
		<input type="hidden" name="_token" value="{!! csrf_token() !!}">
	<label>Name:</label>
		<input type="text" name="name" class="form-control" value="{{Auth::user()->emp_name}}"/>
		<br/>
	<label>Position:</label>
		<select class="form-control" name="position">
              <option id="QA Expert" value="QA Expert">QA Expert</option>
              <option id="Administrator" value="Administrator">Administrator</option>
              <option id="Web Developer" value="Web Developer">Web Developer</option>
            </select>
		<br/>
	<label>Email:</label>
		<input type="email" name="email" class="form-control" value="{{Auth::user()->email}}" />
		<br/>
	<label>ID Number(<i>Username</i>):</label>
		<input type="text" name="username" class="form-control" value="{{Auth::user()->username}}" />
		<br/>
	<button type="submit" class="btn btn-primary">Save</button>
	</form>

	<script type="text/javascript">
			document.getElementById('{{Auth::user()->emp_position}}').selected = "true";
	</script>
@endsection
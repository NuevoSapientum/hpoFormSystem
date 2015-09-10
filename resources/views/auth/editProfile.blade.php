@extends('layout.default')

@section('head')
	<h1>Edit Profile</h1>
@endsection

@section('content')
	<form>
	<label>Name:</label>
		<input type="text" class="form-control" value="{{Auth::user()->emp_name}}"/>
		<br/>
	<label>Position:</label>
		<select class="form-control" name="position">
              <option id="QA Expert" value="QA Expert">QA Expert</option>
              <option id="Administrator" value="Administrator">Administrator</option>
              <option id="Web Developer" value="Web Developer">Web Developer</option>
            </select>
		<br/>
	<label>Email:</label>
		<input type="email" class="form-control" value="{{Auth::user()->email}}" />
		<br/>
	<label>ID Number(<i>Username</i>):</label>
		<input type="text" class="form-control" value="{{Auth::user()->username}}" />
		<br/>
	<button class="btn btn-primary">Save</button>
	</form>

	<script type="text/javascript">
			document.getElementById('{{Auth::user()->emp_position}}').selected = "true";
	</script>
@endsection
@extends('layout.default')

@section('head')
  @if(session('status') == "Success!")
    <div class="alert alert-success">
      <h4>{{session('status')}}</h4>
    </div>
  @elseif(session('status') == "Failed!")
    <div class="alert alert-warning">
      <h4>{{session('status')}}</h4>
    </div>
  @elseif(session('status') == "Please Upload you Profile Picture.")
    <div class="alert alert-warning">
        <h4>{{session('status')}}</h4>
    </div>
  @endif
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
	<form method="POST" action="{{URL::to('/editProfile')}}" name="editProfile" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{!! csrf_token() !!}">
		<label>Image Upload:</label>
		<input type="file" name="image" id="image" />
		<br/>
	<label>Name:</label>
		<input type="text" name="name" class="form-control" value="{{Auth::user()->emp_name}}"/>
		<br/>
	<label>Position:</label>
		<select class="form-control" name="position">
              @foreach($positions_all as $post)
                <option id="{{$post->id}}" value="{{$post->id}}">{{$post->position_name}}</option>
              @endforeach
        </select>
		<br/>
	<label>Email:</label>
		<input type="email" name="email" class="form-control" value="{{Auth::user()->email}}" />
		<br/>
	<button type="submit" name="submit" class="btn btn-primary">Save</button>
	</form>

	<script type="text/javascript">
			document.getElementById('{{Auth::user()->position_id}}').selected = "true";
	</script>
@endsection
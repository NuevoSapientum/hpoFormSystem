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
		<!-- <br/>
    <label>Gender:</label>
    <select class="form-control" name="gender">
        @if(Auth::user()->emp_gender == "Male")
          <option value="Male" selected>Male</option>
          <option value="Female">Female</option>
        @elseif(Auth::user()->emp_gender == "Female")
          <option value="Male">Male</option>
          <option value="Female" selected >Female</option>
        @endif
    </select> -->
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
	<button type="submit" name="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Save</button>
  <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4>Change Password:</h4>
                </div>
                <div class="modal-body">
                    <input type="password" class="form-control" name="password" placeholder="New Password" value="{{old('password')}}" /><br/>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" />
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>
  <button type="button" data-toggle="modal" data-target="#myModal" style="border-radius:0px;border-style: none;  height:34px" name="change_password" class="btn btn-warning"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Change Password</button>
	</form>
	<script type="text/javascript">
			document.getElementById('{{Auth::user()->position_id}}').selected = "true";
	</script>
@endsection
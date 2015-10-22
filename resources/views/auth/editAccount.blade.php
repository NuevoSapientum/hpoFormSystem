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
		<hr/>
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
		<label>Gender:</label>
		<select class="form-control" id="gender" name="gender">
	        @if($user->emp_gender == "Male")
	          <option id="Male" value="Male" selected>Male</option>
	          <option id="Female" value="Female">Female</option>
	        @elseif($user->emp_gender == "Female")
	          <option id="Male" value="Male">Male</option>
	          <option id="Female" selected value="Female" >Female</option>
	        @endif
	    </select>
	    <br/>
		<label>ID Number:</label>
		<input type="number" name="username" class="form-control" value="{{$user->username}}" /><br/>
		<label>Permissioner:</label>
		<div class="radio">
			@if($user->permissioners == 1)
				<label><input type="radio" value="0" name="permissioners" />None</label>
				<label><input type="radio" value="1" checked="checked" name="permissioners" />Supervisor |</label>
				<label><input type="radio" value="2" name="permissioners" />Project Manager |</label>
				<label><input type="radio" value="3" name="permissioners" />Company Representative</label>
			@elseif($user->permissioners == 2)
				<label><input type="radio" value="0" name="permissioners" />None</label>
				<label><input type="radio" value="1" name="permissioners" />Supervisor |</label>
				<label><input type="radio" value="2" checked="checked" name="permissioners" />Project Manager |</label>
				<label><input type="radio" value="3" name="permissioners" />Company Representative</label>
			@elseif($user->permissioners == 3)
				<label><input type="radio" value="0" name="permissioners" />None</label>
				<label><input type="radio" value="1" name="permissioners" />Supervisor |</label>
				<label><input type="radio" value="2" name="permissioners" />Project Manager |</label>
				<label><input type="radio" value="3" checked="checked" name="permissioners" />Company Representative</label>
			@else
				<label><input type="radio" value="0" name="permissioners" checked />None</label>
				<label><input type="radio" value="1" name="permissioners" />Supervisor |</label>
				<label><input type="radio" value="2" name="permissioners" />Project Manager |</label>
				<label><input type="radio" value="3" name="permissioners" />Company Representative</label>
			@endif
		</div>
		<label>Vacation Entitlement:</label>
		<input type="number" name="VL_entitlement" value="{{$user->VL_entitlement}}" class="form-control" />
		<br/>
		<label>Sick Entitlement:</label>
		<input type="number" name="SL_entitlement" value="{{$user->SL_entitlement}}" class="form-control" />
		<br/>
		<div id="ML" style="display:none">
			<label>Maternity Entitlement:</label>
			<input type="number" name="ML_entitlement" value="{{$user->ML_entitlement}}" class="form-control" />
			<br/>	
		</div>
		
		<div id="PL" style="display:none">
			<label>Paternity Entitlement:</label>
			<input type="number" name="PL_entitlement" value="{{$user->PL_entitlement}}" class="form-control" />	
		</div>
		<hr/>
	<button type="submit" class="btn btn-primary confirm">Save</button>
	</form>
	<script type="text/javascript">
			document.getElementById('{{$user->position_id}}').selected = "true";
			if($('#gender').val() == "Male"){
				$('#Male').selected = "true";
				$('#PL').css('display', 'block');
				$('#ML').css('display', 'none');
			}else if($('#gender').val() == "Female"){
				$('#Female').selected = "true";
				$('#PL').css('display', 'none');
				$('#ML').css('display', 'block');
			}

			$('#gender').change(function(){
		        var gender = $('#gender').find(":selected").text();
		        if(gender == "Male"){
		            $('#ML').css('display', 'none');
		            $('#PL').css('display', 'block');
		            // alert(gender);
		        }else if(gender == "Female"){
		            $('#PL').css('display', 'none');
		            $('#ML').css('display', 'block');
		        }
		     });
	</script>
@endsection
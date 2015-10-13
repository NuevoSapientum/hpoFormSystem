@extends('layout.default')

@section('head')
	<h1>Edit Request for Leave of Absence Form</h1>
@endsection

@section('content')
    @foreach($contents as $content)
	<form method="POST" action="{{URL::to('inbox/edit/' . $content->form_id . '/' . $content->id)}}" name="editProfile" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{!! csrf_token() !!}">
		<label>Type of Leave:</label>
		<div class="radio">
			@if($content->leave_type == 1)
		        <label><input type="radio" name="typeofLeave" checked="checked" value="1" />Vacation Leave</label>
		        <label><input type="radio" name="typeofLeave" value="2" />Sick Leave </label>
		        <label><input type="radio" name="typeofLeave" value="3" />Maternity Leave </label>
		        <label><input type="radio" name="typeofLeave" value="4" />Paternity Leave </label>
		    @elseif($content->leave_type == 2)
		    	<label><input type="radio" name="typeofLeave" value="1" />Vacation Leave</label>
		        <label><input type="radio" name="typeofLeave" checked="checked" value="2" />Sick Leave </label>
		        <label><input type="radio" name="typeofLeave" value="3" />Maternity Leave </label>
		        <label><input type="radio" name="typeofLeave" value="4" />Paternity Leave </label>
		    @elseif($content->leave_type == 3)
		    	<label><input type="radio" name="typeofLeave" value="1" />Vacation Leave</label>
		        <label><input type="radio" name="typeofLeave" value="2" />Sick Leave </label>
		        <label><input type="radio" name="typeofLeave" checked="checked" value="3" />Maternity Leave </label>
		        <label><input type="radio" name="typeofLeave" value="4" />Paternity Leave </label>
		    @elseif($content->leave_type == 4)
		    	<label><input type="radio" name="typeofLeave" value="1" />Vacation Leave</label>
		        <label><input type="radio" name="typeofLeave" value="2" />Sick Leave </label>
		        <label><input type="radio" name="typeofLeave" value="3" />Maternity Leave </label>
		        <label><input type="radio" name="typeofLeave" checked="checked" value="4" />Paternity Leave </label>
		    @endif
        </div>
        <br/>
      <label>Reason(s) for Absence:</label>
      <textarea class="form-control" id="textPurpose" name="reasonforAbsence">{{$content->purpose}}</textarea>
      <br/>
      <label>Recommending Approval:</label>
      <select class="form-control" name="recommendApproval">
          @foreach($permissioners as $permissioner)
          	@if($permissioner->id === $content->permission_id1)
            	<option selected="true" value="{{$permissioner->id}}">{{$permissioner->emp_name}}</option>
            @else
            	<option value="{{$permissioner->id}}">{{$permissioner->emp_name}}</option>
            @endif
          @endforeach
      </select>
      <br/>
      <label>Approved by:</label>
      <select class="form-control" name="approvedBy">
          @foreach($permissioners as $permissioner)
          	@if($permissioner->id === $content->permission_id2)
	            <option selected="true" value="{{$permissioner->id}}">{{$permissioner->emp_name}}</option>
	        @else
	        	<option value="{{$permissioner->id}}">{{$permissioner->emp_name}}</option>
          @endif
          @endforeach
      </select><br/>
      <table>
        <!-- Inclusive Dates of Leave -->
      </table>
      <label>Entitlement:</label> 
      <input type="text" class="form-control" name="entitlement" disabled="true" value="{{Auth::user()->entitlement}} Days" /><br/>
      <label>Days Applied For:</label> 
      <br/>
      <select class="form-control" name="days_applied">
      <?php $balance = Auth::user()->entitlement - Auth::user()->days_taken ?>
        @if($balance == 0)
          <option>No days left</option>
        @else
          @for($i = 1; $i <= $balance = Auth::user()->entitlement - Auth::user()->days_taken; $i++)
            @if($i == 1)
              @if($i === $content->days_applied)
              <option selected="true" value="{{$i}}">{{$i}} Day</option>
              @else
              <option value="{{$i}}">{{$i}} Day</option>
              @endif
            @else
              @if($i === $content->days_applied)
              <option selected="true" value="{{$i}}">{{$i}} Days</option>
              @else
              <option value="{{$i}}">{{$i}} Days</option>
              @endif
              
            @endif
          @endfor
        @endif
      </select><br/>
      <label>Balance:</label> 
      <input type="text" class="form-control" disabled value="{{$balance}}"/><br/>
        <button type="submit" name="submit" class="btn btn-primary">Save</button>
	</form>
	@endforeach
@endsection
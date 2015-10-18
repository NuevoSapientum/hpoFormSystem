@extends('layout.default')

@section('head')
	<h1>Edit Request for Leave of Absence Form</h1>
@endsection

@section('content')
    @foreach($contents as $content)
	<form method="POST" action="{{URL::to('inbox/edit/' . $content->form_id . '/' . $content->id)}}" name="editProfile" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{!! csrf_token() !!}">
		<label>Employee Name:</label>
    <input disabled value="{{$content->users->emp_name}}" class="form-control" />
    <br/>
    <label>Type of Leave:</label>
		<div class="radio">
			@if($content->leave_type == 1)
		        <label><input type="radio" name="typeofLeave" id="VL" checked="checked" value="1" />Vacation Leave</label>
		        <label><input type="radio" name="typeofLeave" id="SL" value="2" />Sick Leave </label>
		        <label><input type="radio" name="typeofLeave" id="ML" value="3" />Maternity Leave </label>
		        <label><input type="radio" name="typeofLeave" id="PL" value="4" />Paternity Leave </label>
		    @elseif($content->leave_type == 2)
		    	<label><input type="radio" name="typeofLeave" id="VL" value="1" />Vacation Leave</label>
		        <label><input type="radio" name="typeofLeave" id="SL" checked="checked" value="2" />Sick Leave </label>
		        <label><input type="radio" name="typeofLeave" id="ML" value="3" />Maternity Leave </label>
		        <label><input type="radio" name="typeofLeave" id="PL" value="4" />Paternity Leave </label>
		    @elseif($content->leave_type == 3)
		    	<label><input type="radio" name="typeofLeave" id="VL" value="1" />Vacation Leave</label>
		        <label><input type="radio" name="typeofLeave" id="SL" value="2" />Sick Leave </label>
		        <label><input type="radio" name="typeofLeave" id="ML" checked="checked" value="3" />Maternity Leave </label>
		        <label><input type="radio" name="typeofLeave" id="PL" value="4" />Paternity Leave </label>
		    @elseif($content->leave_type == 4)
		    	<label><input type="radio" name="typeofLeave" id="VL" value="1" />Vacation Leave</label>
		        <label><input type="radio" name="typeofLeave" id="SL" value="2" />Sick Leave </label>
		        <label><input type="radio" name="typeofLeave" id="ML" value="3" />Maternity Leave </label>
		        <label><input type="radio" name="typeofLeave" id="PL" checked="checked" value="4" />Paternity Leave </label>
		    @endif
        </div>
        <hr/>
        <div id="VLShow">
          <?php $balance = Auth::user()->VL_entitlement - Auth::user()->VL_taken ?>
          <label>Vacation Leave Entitlement:</label> 
          <input type="text" class="form-control" name="VL" disabled value="{{Auth::user()->VL_entitlement}} Days" /><br/>
          <label>Days Already Taken:</label> 
          <input type="text" class="form-control" disabled value="{{Auth::user()->VL_taken}}"/><br/>
          <label>Days Applied For:</label> 
          <select class="form-control" name="VL_daysApplied">
            @for($i = 1; $i<=$balance; $i++)
              @if($i == $content->days_applied)
                @if($i == 1)
                  <option selected value="{{$i}}">{{$i}} Day</option>
                @else
                  <option selected value="{{$i}}">{{$i}} Days</option>
                @endif
              @else
                @if($i == 1)
                  <option value="{{$i}}">{{$i}} Day</option>
                @else
                  <option value="{{$i}}">{{$i}} Days</option>
                @endif
              @endif
            @endfor
          </select>
          <br/>
          <label>Balance:</label> 
          <input type="text" class="form-control" disabled value="{{$balance}}"/><br/>
        </div>  

        <div id="SLShow">
          <?php $balance = Auth::user()->SL_entitlement - Auth::user()->SL_taken ?>
          <label>Sick Leave Entitlement:</label> 
          <input type="text" class="form-control" name="SL" disabled value="{{Auth::user()->SL_entitlement}} Days" /><br/>
          <label>Days Already Taken:</label> 
          <input type="text" class="form-control" disabled value="{{Auth::user()->SL_taken}}"/><br/>
          <label>Days Applied For:</label> 
          <select class="form-control" id="SL_daysApplied" name="SL_daysApplied">
            @for($i = 1; $i<=$balance; $i++)
              @if($i == $content->days_applied)
                @if($i == 1)
                  <option selected value="{{$i}}">{{$i}} Day</option>
                @else
                  <option selected value="{{$i}}">{{$i}} Days</option>
                @endif
              @else
                @if($i == 1)
                  <option value="{{$i}}">{{$i}} Day</option>
                @else
                  <option value="{{$i}}">{{$i}} Days</option>
                @endif
              @endif
            @endfor
          </select>
          <br/>
          <label>Balance:</label> 
          <input type="text" class="form-control" disabled value="{{$balance}}"/><br/>
        </div>

        <div id="MLShow">
          <?php $balance = Auth::user()->ML_entitlement - Auth::user()->ML_taken ?>
          <label>Maternal Leave Entitlement:</label> 
          <input type="text" class="form-control" name="ML" disabled value="{{Auth::user()->ML_entitlement}} Days" /><br/>
          <label>Days Already Taken:</label> 
          <input type="text" class="form-control" disabled value="{{Auth::user()->ML_taken}}"/><br/>
          <label>Days Applied For:</label> 
          <select class="form-control" name="ML_daysApplied">
            @for($i = 1; $i<=$balance; $i++)
              @if($i == $content->days_applied)
                @if($i == 1)
                  <option selected value="{{$i}}">{{$i}} Day</option>
                @else
                  <option selected value="{{$i}}">{{$i}} Days</option>
                @endif
              @else
                @if($i == 1)
                  <option value="{{$i}}">{{$i}} Day</option>
                @else
                  <option value="{{$i}}">{{$i}} Days</option>
                @endif
              @endif
            @endfor
          </select>
          <br/>
          <label>Balance:</label> 
          <input type="text" class="form-control" disabled value="{{$balance}}"/><br/>
        </div>

        <div id="PLShow">
          <?php $balance = Auth::user()->PL_entitlement - Auth::user()->PL_taken ?>
          <label>Paternal Leave Entitlement:</label> 
          <input type="text" class="form-control" name="PL" disabled value="{{Auth::user()->PL_entitlement}} Days" /><br/>
          <label>Days Already Taken:</label> 
          <input type="text" class="form-control" disabled value="{{Auth::user()->PL_taken}}"/><br/>
          <label>Days Applied For:</label> 
          <select class="form-control" name="PL_daysApplied">
            @for($i = 1; $i<=$balance; $i++)
              @if($i == $content->days_applied)
                @if($i == 1)
                  <option selected value="{{$i}}">{{$i}} Day</option>
                @else
                  <option selected value="{{$i}}">{{$i}} Days</option>
                @endif
              @else
                @if($i == 1)
                  <option value="{{$i}}">{{$i}} Day</option>
                @else
                  <option value="{{$i}}">{{$i}} Days</option>
                @endif
              @endif
            @endfor
          </select>
          <br/>
          <label>Balance:</label> 
          <input type="text" class="form-control" disabled value="{{$balance}}"/><br/>
        </div>
        <label>Start Date:</label>
        <input type="date" class="form-control" value="{{$content->start_date}}" />
        <hr/>
      <label>Reason(s) for Absence:</label>
      <textarea class="form-control" id="textPurpose" name="reasonforAbsence">{{$content->purpose}}</textarea>
      <br/>
      <label>Recommending Approval:</label>
      <select class="form-control" name="recommendApproval">
          @foreach($Supervisors as $Supervisor)
          	@if($Supervisor->id === $content->permission_id1)
            	<option selected="true" value="{{$Supervisor->id}}">{{$Supervisor->emp_name}}</option>
            @else
            	<option value="{{$Supervisor->id}}">{{$Supervisor->emp_name}}</option>
            @endif
          @endforeach
      </select>
      <br/>
      <label>Approved by:</label>
      <select class="form-control" name="approvedBy">
          @foreach($HRs as $HR)
          	@if($HR->id === $content->permission_id2)
	            <option selected="true" value="{{$HR->id}}">{{$HR->emp_name}}</option>
	        @else
	        	<option value="{{$HR->id}}">{{$HR->emp_name}}</option>
          @endif
          @endforeach
      </select><br/>
        <button type="submit" name="submit" class="btn btn-primary">Save</button>
	</form>
	@endforeach
@endsection
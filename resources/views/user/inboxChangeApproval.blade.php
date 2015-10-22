@extends('layout.default')

@section('head')
	<h1>Change Schedule</h1>
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
    @foreach($contents as $content)
	<form method="POST" action="{{URL::to('approval/view/' . $content->form_type . '/' . $content->chgschd_id)}}" name="editProfile" enctype="multipart/form-data">
		<hr/>
      <label>Employee Name:</label>
      <input disabled value="{{$content->users->emp_name}}" class="form-control" />
      <hr/>
      <label>Shift Schedule:</label>
      <input value="{{$currentShift}}" disabled class="form-control" />
      <hr/>
      <label><u>Change Shift Schedule:</u></label><br/>
      <label>From:</label>
      <input disabled value="{{date('F d, Y', strtotime($content->dateFromShift))}}" class="form-control"/>
      <br/>
      <label>To:</label>
      <input disabled value="{{date('F d, Y', strtotime($content->dateToShift))}}" class="form-control"/><br/>
      <label>Shift Schedule:</label>
      <select class="form-control" disabled>
        @foreach($shifts as $shift)
          @if($shift->id === $content->shift_id)
            <option disabled value="{{$shift->id}}" >{{date('h:i A', strtotime($shift->shift_from))}} to {{date('h:i A', strtotime($shift->shift_to))}}</option>
          @endif
        @endforeach
      </select>
      <hr/>
      <label>Reason:</label>
      <textarea class="form-control" disabled>{{$content->purpose}}</textarea>
	    <hr/>
	    <label><u>Approved by:</u></label>
	    <br/>
      	<label>Supervisor:</label>
    	   @foreach($Supervisors as $Supervisor)
    	   	 @if($Supervisor->id === $content->permission_id1)
            <input disabled class="form-control" value="{{$Supervisor->emp_name}}" />
            @endif
      		@endforeach
          <div class="radio">
            @if($content->permission_1 === 1)
                <label><input type="radio" disabled checked="true"/>Yes</label>
                <label><input type="radio" disabled />No</label>
              @elseif($content->permission_1 === 2)
                <label><input type="radio" disabled />Yes</label>
                <label><input type="radio" disabled checked="true"/>No</label>
            @else
                <label><input type="radio" disabled />Yes</label>
                <label><input type="radio" disabled />No</label>
            @endif
        </div>
      	<br/>
      	<label>Project Manager:</label>
      	  @foreach($PMs as $PM)
            @if($PM->id === $content->permission_id2)
              <input disabled="true" class="form-control" value="{{$PM->emp_name}}" />
            @endif
          @endforeach
          <div class="radio">
            @if($content->permission_2 === 1)
              <label><input type="radio" checked="true" disabled />Yes</label>
              <label><input type="radio" disabled />No</label>
            @elseif($content->permission_2 === 2)
              <label><input type="radio" disabled />Yes</label>
              <label><input type="radio" checked="true" disabled />No</label>
            @else
              <label><input type="radio" disabled />Yes</label>
              <label><input type="radio" disabled />No</label>
            @endif
          </div>
      	<hr/>
      	<label><u>Noted by:</u></label>
      	<br/>
      	<label>Operation:</label>
      	  @foreach($permissioners as $permissioner)
      	  	@if($permissioner->id === $content->permission_id3)
              <input type="text" disabled class="form-control" value="{{$permissioner->emp_name}}" />
            @endif
      	  @endforeach
          <div class="radio">
            @if($content->permission_3 === 1)
              <label><input type="radio" checked="true" disabled />Yes</label>
              <label><input type="radio" disabled />No</label>
            @elseif($content->permission_3 === 2)
              <label><input type="radio" disabled />Yes</label>
              <label><input type="radio" checked="true" disabled />No</label>
            @else
              <label><input type="radio" disabled />Yes</label>
              <label><input type="radio" disabled />No</label>
            @endif
          </div>
      	<br/>
      	<label>HR:</label>
        	  @foreach($HRs as $HR)
        	  	@if($HR->id === $content->permission_id4)
                <input disabled="true" class="form-control" value="{{$HR->emp_name}}" />
              @endif
        	  @endforeach
            <div class="radio">
              @if($content->permission_4 === 1)
                <label><input type="radio" checked="true" disabled />Yes</label>
                <label><input type="radio" disabled />No</label>
              @elseif($content->permission_4 === 2)
                <label><input type="radio" disabled />Yes</label>
                <label><input type="radio" checked="true" disabled />No</label>
              @else
                <label><input type="radio" disabled />Yes</label>
                <label><input type="radio" disabled />No</label>
              @endif
            </div>
            <hr/>
          <label>Note:</label>
      	     <textarea class="form-control" disabled >{{$content->reason}}</textarea>
        <hr/>
	</form>
	<script type="text/javascript">
	</script>
	@endforeach
@endsection
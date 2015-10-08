@extends('layout.default')

@section('head')
	<h1>Request for Leave of Absence</h1>
@endsection

@section('content')
    @foreach($contents as $content)
	<form method="POST" action="{{URL::to('inbox/edit/' . $content->form_type . '/' . $content->tbl_leaveid)}}" name="editProfile" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{!! csrf_token() !!}">
		<label>Type of Leave:</label>
		<div class="radio">
			@if($content->leave_type == 1)
		        <label><input type="radio" disabled name="typeofLeave" checked="checked" value="1" />Vacation Leave</label>
		        <label><input type="radio" disabled name="typeofLeave" value="2" />Sick Leave </label>
		        <label><input type="radio" disabled name="typeofLeave" value="3" />Maternity Leave </label>
		        <label><input type="radio" disabled name="typeofLeave" value="4" />Paternity Leave </label>
		    @elseif($content->leave_type == 2)
		    	<label><input type="radio" disabled name="typeofLeave" value="1" />Vacation Leave</label>
		        <label><input type="radio" disabled name="typeofLeave" checked="checked" value="2" />Sick Leave </label>
		        <label><input type="radio" disabled name="typeofLeave" value="3" />Maternity Leave </label>
		        <label><input type="radio" disabled name="typeofLeave" value="4" />Paternity Leave </label>
		    @elseif($content->leave_type == 3)
		    	<label><input type="radio" disabled name="typeofLeave" value="1" />Vacation Leave</label>
		        <label><input type="radio" disabled name="typeofLeave" value="2" />Sick Leave </label>
		        <label><input type="radio" disabled name="typeofLeave" checked="checked" value="3" />Maternity Leave </label>
		        <label><input type="radio" disabled name="typeofLeave" value="4" />Paternity Leave </label>
		    @elseif($content->leave_type == 4)
		    	<label><input type="radio" disabled name="typeofLeave" value="1" />Vacation Leave</label>
		        <label><input type="radio" disabled name="typeofLeave" value="2" />Sick Leave </label>
		        <label><input type="radio" disabled name="typeofLeave" value="3" />Maternity Leave </label>
		        <label><input type="radio" disabled name="typeofLeave" checked="checked" value="4" />Paternity Leave </label>
		    @endif
        </div>
        <br/>
      <label>Reason(s) for Absence:</label>
      <textarea class="form-control" disabled >{{$content->reason}}</textarea>
      <br/>
      <label>Recommending Approval:</label>
        @foreach($permissioners as $permissioner)
        	@if($permissioner->id === $content->permission_id1)
          	<input type="text" disabled class="form-control" value="{{$permissioner->emp_name}}"/>
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
      <label>Approved by:</label>
        @foreach($permissioners as $permissioner)
        	@if($permissioner->id === $content->permission_id2)
            <input type="text" disabled class="form-control" value="{{$permissioner->emp_name}}" />
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
      <br/>
      <table>
        <!-- Inclusive Dates of Leave -->
      </table>
      <label>Days Applied For:</label> 
      @if($content->days_applied == 1)
        <input type="text" class="form-control" value="{{$content->days_applied}} Day" />
      @else
        <input type="text" class="form-control" value="{{$content->days_applied}} Days" />
      @endif
      <br/>
      <label>Note:</label>
        <textarea class="form-control" disabled >{{$content->requestNote}}</textarea>
      <hr/>
	</form>
	<script type="text/javascript">
	</script>
	@endforeach
@endsection
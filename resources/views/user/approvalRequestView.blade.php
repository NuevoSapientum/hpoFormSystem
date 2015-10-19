@extends('layout.default')

@section('head')
	<h1>Edit Request for Leave of Absence Form</h1>
@endsection

@section('content')
    @foreach($contents as $content)
	<form method="POST" action="{{URL::to('approval/view/' . $content->form_id . '/' . $content->id)}}" name="editProfile" enctype="multipart/form-data">
		<hr/>
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <label>Employee Name:</label>
    <input disabled value="{{$content->users->emp_name}}" class="form-control" />
    <br/>
		<label>Type of Leave:</label>
        @if($content->leave_type == 1)
          <div class="radio" >
            <label><input type="radio" disabled checked="checked" />Vacation Leave</label>
            <label><input type="radio" disabled />Sick Leave </label>
            <label><input type="radio" disabled />Maternity Leave </label>
            <label><input type="radio" disabled />Paternity Leave </label>
          </div>
            <hr/>
            <label>Vacation Leave Entitlement:</label> 
            @if($content->users->VL_entitlement == 1)
              <input class="form-control" disabled value="{{$content->users->VL_entitlement}} Day" /><br/>
            @else
              <input class="form-control" disabled value="{{$content->users->VL_entitlement}} Days" /><br/>
            @endif

            <label>Days Already Taken:</label> 
            <input class="form-control" disabled value="{{$content->users->VL_taken}}"/><br/>
            <label>Days Applied For:</label> 
            @if($content->days_applied == 1)
              <input class="form-control" disabled value="{{$content->days_applied}} Day"/><br/>
            @else
              <input class="form-control" disabled value="{{$content->days_applied}} Days"/><br/>
            @endif
              <input type="hidden" name="VLDays" value="{{$content->days_applied + $content->users->days_taken}}" />
        @elseif($content->leave_type == 2)
          <div class="radio">
            <label><input type="radio" disabled />Vacation Leave</label>
            <label><input type="radio" disabled checked="checked" />Sick Leave </label>
            <label><input type="radio" disabled />Maternity Leave </label>
            <label><input type="radio" disabled />Paternity Leave </label>
          </div>
          <hr/>
          <label>Sick Leave Entitlement:</label> 
            @if($content->users->SL_entitlement == 1)
              <input class="form-control" disabled value="{{$content->users->SL_entitlement}} Day" /><br/>
            @else
              <input class="form-control" disabled value="{{$content->users->SL_entitlement}} Days" /><br/>
            @endif

            <label>Days Already Taken:</label> 
            <input class="form-control" disabled value="{{$content->users->SL_taken}}"/><br/>
            <label>Days Applied For:</label> 
            @if($content->days_applied == 1)
              <input class="form-control" disabled value="{{$content->days_applied}} Day"/><br/>
            @else
              <input class="form-control" disabled value="{{$content->days_applied}} Days"/><br/>
            @endif
            <input type="hidden" name="SLDays" value="{{$content->days_applied + $content->users->days_taken}}" />
        @elseif($content->leave_type == 3)
          <div class="radio">
            <label><input type="radio" disabled />Vacation Leave</label>
            <label><input type="radio" disabled />Sick Leave </label>
            <label><input type="radio" disabled checked="checked" />Maternity Leave </label>
            <label><input type="radio" disabled value="4" />Paternity Leave </label>
          </div>
          <hr/>
          <label>Maternity Leave Entitlement:</label> 
            @if($content->users->ML_entitlement == 1)
              <input class="form-control" disabled value="{{$content->users->ML_entitlement}} Day" /><br/>
            @else
              <input class="form-control" disabled value="{{$content->users->ML_entitlement}} Days" /><br/>
            @endif

            <label>Days Already Taken:</label> 
            <input class="form-control" disabled value="{{$content->users->ML_taken}}"/><br/>
            <label>Days Applied For:</label> 
            @if($content->days_applied == 1)
              <input class="form-control" disabled value="{{$content->days_applied}} Day"/><br/>
            @else
              <input class="form-control" disabled value="{{$content->days_applied}} Days"/><br/>
            @endif
            <input type="hidden" name="MLDays" value="{{$content->days_applied + $content->users->days_taken}}" />
        @elseif($content->leave_type == 4)
          <div class="radio">
            <label><input type="radio" disabled />Vacation Leave</label>
            <label><input type="radio" disabled />Sick Leave </label>
            <label><input type="radio" disabled />Maternity Leave </label>
            <label><input type="radio" disabled checked="checked" />Paternity Leave </label>
          </div>
          <hr/>
          <label>Paternal Leave Entitlement:</label> 
            @if($content->users->VL_entitlement == 1)
              <input class="form-control" disabled value="{{$content->users->PL_entitlement}} Day" /><br/>
            @else
              <input class="form-control" disabled value="{{$content->users->PL_entitlement}} Days" /><br/>
            @endif

            <label>Days Already Taken:</label> 
            <input class="form-control" disabled value="{{$content->users->PL_taken}}"/><br/>
            <label>Days Applied For:</label> 
            @if($content->days_applied == 1)
              <input class="form-control" disabled value="{{$content->days_applied}} Day"/><br/>
            @else
              <input class="form-control" disabled value="{{$content->days_applied}} Days"/><br/>
            @endif
            <input type="hidden" name="PLDays" value="{{$content->days_applied + $content->users->days_taken}}" />
        @endif
      <label>Start Date:</label>
      <input type="date" class="form-control" disabled value="{{$content->start_date}}" />
      <br/>
      <label>Reason(s) for Absence:</label>
      <textarea class="form-control" disabled="true">{{$content->purpose}}</textarea>
      <hr/>
      <label>Recommending Approval:</label>
      @foreach($Supervisors as $Supervisor)
      	@if($Supervisor->id === $content->permission_id1)
        	<input type="text" class="form-control" disabled="true" value="{{$Supervisor->emp_name}}"/>
        @endif
      @endforeach
      <div class="radio">
        @if($content->permission_2 === 0 && $content->permission_id1 === Auth::user()->id)
            @if($content->permission_1 === 1)
              <label><input type="radio" disabled checked="true"/>Yes</label>
              <label><input type="radio" disabled />No</label>
            @elseif($content->permission_1 === 2)
              <label><input type="radio" disabled />Yes</label>
              <label><input type="radio" disabled checked="true"/>No</label>>
          @else
              <label><input type="radio" id="permission_1yes" name="permission_1" value="1" />Yes</label>
              <label><input type="radio" id="permission_1no" name="permission_1" value="2" />No</label>
          @endif
          
        @else
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
        @endif
      </div>
      <br/>
      <label>Approved by:</label>
      @foreach($HRs as $HR)
      	@if($HR->id === $content->permission_id2)
          <input type="text" class="form-control" disabled="true" value="{{$HR->emp_name}}"/>
        @endif
      @endforeach
      <div class="radio">
        @if($content->permission_1 === 1 && Auth::user()->id === $content->permission_id2)
            @if($content->permission_2 === 1)
              <label><input type="radio" disabled checked="true"/>Yes</label>
              <label><input type="radio" disabled />No</label>
            @elseif($content->permission_2 === 2)
              <label><input type="radio" id="permission_2yes" name="permission_2" value="1" />Yes</label>
              <label><input type="radio" id="permission_2no" name="permission_2" checked="true" value="2" />No</label>
          @else
              <label><input type="radio" id="permission_2yes" name="permission_2" value="1" />Yes</label>
              <label><input type="radio" id="permission_2no" name="permission_2" value="2" />No</label>
          @endif
        @else
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
        @endif
      </div>
      <hr/>
      @if($content->permission_1 == 2 || $content->permission_2 == 2 || $content->permission_2 == 1)
          <label>Note:</label>
          <textarea disabled class="form-control">{{$content->reason}}</textarea>
    @else
      <div class="modal fade" id="false" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4>Note:</h4>
                </div>
                <div class="modal-body">
                  <textarea class="form-control" id="note" name="note" placeholder="Your Note Please:"></textarea>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>
    <button type="submit" id="submit" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Save</button>
	 @endif
  </form>
	<script type="text/javascript">
    $(document).ready(function() {
       $('input[type="radio"]').click(function() {
          // alert($(this).attr('id') == 'permission_2no');
           if($(this).attr('id') == 'permission_1no' || $(this).attr('id') == 'permission_2no') {
                $('#false').attr('id', 'myModal');
                $('#submit').attr('type', 'button');
           }else {
                $('#myModal').attr('id', 'false');
                $('#submit').attr('type', 'submit');
           }
       });
    });
	</script>
	@endforeach
@endsection
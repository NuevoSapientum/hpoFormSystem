@extends('layout.default')

@section('head')
	<h1>Edit Change Schedule Form</h1>
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
	<form method="POST" action="{{URL::to('approval/view/' . $content->form_id . '/' . $content->id)}}" name="editProfile" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{!! csrf_token() !!}">
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
            @if($content->permission_2 === 0 && $content->permission_id1 === Auth::user()->id)
              @if($content->permission_1 === 1)
                <label><input type="radio" disabled checked="true"/>Yes</label>
                <label><input type="radio" disabled />No</label>
              @elseif($content->permission_1 === 2)
                <label><input type="radio" disabled  />Yes</label>
                <label><input type="radio" disabled checked="true" />No</label>
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
      	<label>Project Manager:</label>
      	  @foreach($PMs as $PM)
            @if($PM->id === $content->permission_id2)
              <input disabled="true" class="form-control" value="{{$PM->emp_name}}" />
            @endif
          @endforeach
          <div class="radio">
            @if($content->permission_1 === 1 && Auth::user()->id === $content->permission_id2)
              @if($content->permission_2 === 1)
                <label><input type="radio" disabled checked="true"/>Yes</label>
                <label><input type="radio" disabled />No</label>
              @elseif($content->permission_2 === 2)
                <label><input type="radio" disabled  />Yes</label>
                <label><input type="radio" disabled checked="true" />No</label>
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
      	<label><u>Noted by:</u></label>
      	<br/>
      	<label>Operation:</label>
      	  @foreach($permissioners as $permissioner)
      	  	@if($permissioner->id === $content->permission_id3)
              <input type="text" disabled class="form-control" value="{{$permissioner->emp_name}}" />
            @endif
      	  @endforeach
          <div class="radio">
            @if($content->permission_2 === 1 && Auth::user()->id === $content->permission_id3)
              @if($content->permission_3 === 1)
                <label><input type="radio" disabled checked="true" name="permission_3" value="1" />Yes</label>
                <label><input type="radio" disabled name="permission_3" value="2" />No</label>
              @elseif($content->permission_3 === 2)
                <label><input type="radio" disabled  />Yes</label>
                <label><input type="radio" disabled checked="true" />No</label>
            @else
                <label><input type="radio" id="permission_3yes" name="permission_3" value="1" />Yes</label>
                <label><input type="radio" id="permission_3no" name="permission_3" value="2" />No</label>
            @endif
            @else
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
              @if($content->permission_3 === 1 && Auth::user()->id === $content->permission_id4)
                @if($content->permission_4 === 1)
                  <label><input type="radio" disabled checked="true" />Yes</label>
                  <label><input type="radio" disabled />No</label>
                @elseif($content->permission_4 === 2)
                  <label><input type="radio" disabled  />Yes</label>
                  <label><input type="radio" disabled checked="true" />No</label>
              @else
                  <label><input type="radio" id="permission_4yes" name="permission_4" value="1" />Yes</label>
                  <label><input type="radio" id="permission_4no" name="permission_4" value="2" />No</label>
              @endif
              @else
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
              @endif
            </div>
      	<hr/>
         @if($content->permission_1 == 2 || $content->permission_2 == 2 || $content->permission_3 == 2
          || $content->permission_4 == 2)
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
           if($(this).attr('id') == 'permission_1no' || $(this).attr('id') == 'permission_2no' 
                || $(this).attr('id') == 'permission_3no' || $(this).attr('id') == 'permission_4no') {
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
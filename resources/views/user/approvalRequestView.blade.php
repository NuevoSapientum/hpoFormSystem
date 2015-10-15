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
		<div class="radio" >
        @if($content->leave_type == 1)
            <label><input type="radio" disabled checked="checked" />Vacation Leave</label>
            <label><input type="radio" disabled />Sick Leave </label>
            <label><input type="radio" disabled />Maternity Leave </label>
            <label><input type="radio" disabled />Paternity Leave </label>
        @elseif($content->leave_type == 2)
          <label><input type="radio" disabled />Vacation Leave</label>
            <label><input type="radio" disabled checked="checked" />Sick Leave </label>
            <label><input type="radio" disabled />Maternity Leave </label>
            <label><input type="radio" disabled />Paternity Leave </label>
        @elseif($content->leave_type == 3)
          <label><input type="radio" disabled />Vacation Leave</label>
            <label><input type="radio" disabled />Sick Leave </label>
            <label><input type="radio" disabled checked="checked" />Maternity Leave </label>
            <label><input type="radio" disabled value="4" />Paternity Leave </label>
        @elseif($content->leave_type == 4)
          <label><input type="radio" disabled />Vacation Leave</label>
            <label><input type="radio" disabled />Sick Leave </label>
            <label><input type="radio" disabled />Maternity Leave </label>
            <label><input type="radio" disabled checked="checked" />Paternity Leave </label>
        @endif
        </div>
        <br/>
      <label>Reason(s) for Absence:</label>
      <textarea class="form-control" disabled="true">{{$content->purpose}}</textarea>
      <br/>
      <label>Recommending Approval:</label>
      @foreach($permissioners as $permissioner)
      	@if($permissioner->id === $content->permission_id1)
        	<input type="text" class="form-control" disabled="true" value="{{$permissioner->emp_name}}"/>
        @endif
      @endforeach
      <div class="radio">
        @if($content->permission_2 === 0 && $content->permission_id1 === Auth::user()->id)
            @if($content->permission_1 === 1)
              <label><input type="radio" disabled checked="true"/>Yes</label>
              <label><input type="radio" disabled />No</label>
            @elseif($content->permission_1 === 2)
              <label><input type="radio" id="permission_1yes" name="permission_1" value="1" />Yes</label>
              <label><input type="radio" id="permission_1no" name="permission_1" checked="true" value="2" />No</label>
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
      @foreach($permissioners as $permissioner)
      	@if($permissioner->id === $content->permission_id2)
          <input type="text" class="form-control" disabled="true" value="{{$permissioner->emp_name}}"/>
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
      <br/>
      <table>
        <!-- Inclusive Dates of Leave -->
      </table>
      <label>Days Applied For:</label> 
      <br/>
      @if($content->days_applied === 1)
      <input class="form-control" disabled value="{{$content->days_applied}} Day" />
      @else
      <input class="form-control" disabled value="{{$content->days_applied}} Days" />
      @endif
      <hr/>
      @if($content->permission_1 == 2 || $content->permission_2 == 2)
          <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4>Note:</h4>
                </div>
                <div class="modal-body">
                  <textarea class="form-control" id="note" name="note">{{$content->reason}}</textarea>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>
      <button type="button" id="submit" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Save</button>
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
    // if({{$content->permission_1}} === 1){
    //   document.getElementById('permission_1yes').checked = 'true';
    //   //Check if the user is the next permissioner
    //   if({{$content->permission_id1}} == {{Auth::user()->id}}){
    //     document.getElementById('permission_2yes').disabled = false;
    //     document.getElementById('permission_2no').disabled = false;
    //   }
    // }else if({{$content->permission_1}} === 2){
    //   document.getElementById('permission_1no').checked = 'true';
    // }
    // if({{$content->permission_id1}} === {{Auth::user()->id}}){
    //   document.getElementById('permission_1yes').disabled = false;
    //   document.getElementById('permission_1no').disabled = false;
    // }

    // if({{$content->permission_2}} === 1){
    //   document.getElementById('permission_2yes').checked = 'true';
    // }else if({{$content->permission_2}} === 2){
    //   document.getElementById('permission_2no').checked = 'true';
    // }

	</script>
	@endforeach
@endsection
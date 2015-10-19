@extends('layout.default')

@section('head')
	<h1>Edit Overtime Authorization Slip</h1>
@endsection

@section('content')
    @foreach($contents as $content)
	<form method="POST" action="{{URL::to('approval/view/' . $content->form_id . '/' . $content->id)}}" name="editProfile" enctype="multipart/form-data">
		  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <label>Employee Name:</label>
        <input disabled value="{{$content->users->emp_name}}" class="form-control" />
        <br/>
        <label>Date/Time:</label>
        @foreach($dateTime as $dateAndtime)
        <?php $count++ ?>
        <div id="datesTime">
          <input type="date" disabled class='form-control' value="{{$dateAndtime->date_overtime}}"/> <br/>
          <input type="time" disabled class='form-control' value="{{$dateAndtime->time_overtime}}" /><hr/>
        </div>
        @endforeach
        <label>Client Paid:</label>
      <div class="radio">
          @if($content->permission_id1 === Auth::user()->id)
            @if($content->client_paid === 1)
              <label><input type="radio" disabled checked="true"/>Yes</label>
              <label><input type="radio" disabled />No</label>
            @elseif($content->client_paid === 2)
              <label><input type="radio" disabled />Yes</label>
              <label><input type="radio" disabled checked="true"/>No</label>
          @else
              <label><input type="radio" name="client_paid" value="1" />Yes</label>
              <label><input type="radio" name="client_paid" value="2" />No</label>
          @endif
          
        @else
          @if($content->client_paid === 1)
              <label><input type="radio" disabled checked="true"/>Yes</label>
              <label><input type="radio" disabled />No</label>
            @elseif($content->client_paid === 2)
              <label><input type="radio" disabled />Yes</label>
              <label><input type="radio" disabled checked="true"/>No</label>
          @else
              <label><input type="radio" disabled />Yes</label>
              <label><input type="radio" disabled />No</label>
          @endif
        @endif
      </div>
      <hr/>
        <label>Supervisor Signature:</label>
        <select disabled class="form-control">
            @foreach($Supervisors as $Supervisor)
              @if($Supervisor->id === $content->permission_id1)
                <option disabled selected="true" value="{{$Supervisor->id}}">{{$Supervisor->emp_name}}</option>
              @else
                <option disabled value="{{$Supervisor->id}}">{{$Supervisor->emp_name}}</option>
              @endif
            @endforeach
        </select>
        <div class="radio">
          @if($content->permission_id1 === Auth::user()->id)
            @if($content->permission_1 === 1)
              <label><input type="radio" disabled checked="true"/>Yes</label>
              <label><input type="radio" disabled />No</label>
            @elseif($content->permission_1 === 2)
              <label><input type="radio" disabled />Yes</label>
              <label><input type="radio" disabled checked="true"/>No</label>
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
        <label>Detailed Purpose of Overtime:</label>
        <textarea class="form-control" disabled>{{$content->purpose}}</textarea>
        <br/>
      <hr/>
      @if($content->permission_1 == 2 || $content->permission_1 == 1)
       <label>Note:</label>
       <textarea class="form-control" disabled>{{$content->reason}}</textarea>
       <hr/>
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
           if($(this).attr('id') == 'permission_1no') {
                $('#false').attr('id', 'myModal');
                $('#submit').attr('type', 'button');
           }else if($(this).attr('id') == 'permission_1yes'){
                $('#myModal').attr('id', 'false');
                $('#submit').attr('type', 'submit');
           }else{
                $('#false').attr('id', 'myModal');
                $('#submit').attr('type', 'button');
           }
       });
    });
	</script>
	@endforeach
@endsection
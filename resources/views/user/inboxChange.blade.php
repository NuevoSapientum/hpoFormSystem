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
  <form method="POST" action="{{URL::to('inbox/edit/' . $content->form_id . '/' . $content->id)}}" name="editProfile" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <hr/>
    <label>Employee Name:</label>
    <input disabled value="{{$content->users->emp_name}}" class="form-control" />
    <hr/>
      <label>Shift Schedule:</label>
      <input value="{{$currentShift}}" disabled class="form-control" />
      <hr/>
      <label><u>Change Shift Schedule:</u></label><br/>
      <label>From:</label>
      <input type="date" name="dateFromShift" value="{{$content->dateFromShift}}" class="form-control"/>
      <br/>
      <label>To:</label>
      <input type="date" name="dateToShift" value="{{$content->dateToShift}}" class="form-control"/><br/>
      <label>Shift Schedule:</label>
      <select class="form-control" name="shiftSchedule">
        @foreach($shifts as $shift)
          @if($shift->id === $content->shift_id)
            <option selected value="{{$shift->id}}" >{{date('h:i A', strtotime($shift->shift_from))}} to {{date('h:i A', strtotime($shift->shift_to))}}</option>
          @else
            <option value="{{$shift->id}}" >{{date('h:i A', strtotime($shift->shift_from))}} to {{date('h:i A', strtotime($shift->shift_to))}}</option>
          @endif
        @endforeach
      </select>
      <hr/>
      <label>Reason:</label>
      <textarea class="form-control" name="reasonforChangeSchedule">{{$content->purpose}}</textarea>
      <hr/>
      <label><u>Approved by:</u></label>
      <br/>
      <label>Supervisor:</label>
      <select class="form-control" name="supervisor">
           @foreach($Supervisors as $Supervisor)
            @if($Supervisor->id == $content->permission_id1)
              <option selected value="{{$Supervisor->id}}">{{$Supervisor->emp_name}}</option>
            @else
              <option value="{{$Supervisor->id}}">{{$Supervisor->emp_name}}</option>
            @endif
          @endforeach
      </select>
      <br/>
      <label>Project Manager:</label>
      <select class="form-control" name="projectManager">
          @foreach($PMs as $PM)
            @if($PM->id == $content->permission_id2)
              <option selected value="{{$PM->id}}">{{$PM->emp_name}}</option>
            @else
              <option value="{{$PM->id}}">{{$PM->emp_name}}</option>
            @endif
          @endforeach
      </select>
      <hr/>
      <label><u>Noted by:</u></label>
      <br/>
      <label>Operation:</label>
      <select class="form-control" name="permissioner">
          @foreach($permissioners as $permissioner)
            @if($permissioner->id == $content->permission_id3)
              <option selected value="{{$permissioner->id}}">{{$permissioner->emp_name}}</option>
            @else
              <option value="{{$permissioner->id}}">{{$permissioner->emp_name}}</option>
            @endif
          @endforeach
      </select>
      <br/>
      <label>HR:</label>
      <select class="form-control" name="HR">
          @foreach($HRs as $HR)
            @if($HR->id == $content->permission_id4)
              <option value="{{$HR->id}}">{{$HR->emp_name}}</option>
            @else
              <option value="{{$HR->id}}">{{$HR->emp_name}}</option>
            @endif
          @endforeach
      </select>
        <hr/>
    <button type="submit" name="submit" class="btn btn-primary">Save</button>
  </form>
  @endforeach
@endsection

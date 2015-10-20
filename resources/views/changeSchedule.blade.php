@extends('layout.default')

@section('head')
  <h1>
    Change Schedule Form
  </h1>
@endsection

@section('content')
    <form method="POST" action="{{URL::to('/changeSchedule')}}">
      <input type="hidden" name="_token" value="{!! csrf_token() !!}">
      @if (count($errors) > 0)
      <div class="alert alert-danger">
      <strong>Whoops! </strong> There were some problems with your input. <br> <br>
      <ul>

              @foreach ($errors->all() as $error)
           <li>{{ $error }} </li>
          @endforeach
      </ul>
      </div>
      @endif
      <hr/>
      <label><u>Current Schedule:</u></label><br/>
      <label>Original Schedule:</label>
      <input disabled type="date" class="form-control"/><br/>
      <input class="form-control" disabled />
      <hr/>
      <label><u>Shift Schedule:</u></label><br/>
      <label>From:</label>
      <input type="date" name="dateFromShift" class="form-control"/>
      <br/>
      <label>To:</label>
      <input type="date" name="dateToShift" class="form-control"/><br/>
      <select class="form-control">
        @foreach($shifts as $shift)
          <option >{{date('h:i A', strtotime($shift->shift_from))}} to {{date('h:i A', strtotime($shift->shift_to))}}</option>
        @endforeach
      </select>
      <hr/>
      <label>Reason:</label>
      <textarea class="form-control" name="reasonforChangeSchedule"></textarea>
      <hr/>
      <label><u>Approved by:</u></label>
      <br/>
      <label>Supervisor:</label>
      <select class="form-control" name="supervisor">
           @foreach($Supervisors as $Supervisor)
            <option value="{{$Supervisor->id}}">{{$Supervisor->emp_name}}</option>
          @endforeach
      </select>
      <br/>
      <label>Project Manager:</label>
      <select class="form-control" name="projectManager">
          @foreach($PMs as $PM)
            <option value="{{$PM->id}}">{{$PM->emp_name}}</option>
          @endforeach
      </select>
      <hr/>
      <label><u>Noted by:</u></label>
      <br/>
      <label>Operation:</label>
      <select class="form-control" name="permissioner">
          @foreach($permissioners as $permissioner)
            <option value="{{$permissioner->id}}">{{$permissioner->emp_name}}</option>
          @endforeach
      </select>
      <br/>
      <label>HR:</label>
      <select class="form-control" name="HR">
          @foreach($HRs as $HR)
            <option value="{{$HR->id}}">{{$HR->emp_name}}</option>
          @endforeach
      </select>
      <hr/>
      <button type="submit" class="btn btn-primary">Submit</button>
  </form>
@endsection

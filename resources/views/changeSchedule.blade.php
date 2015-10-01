@extends('layout.default')

@section('head')
  <h1>
    Change Schedule Form
  </h1>
@endsection

@section('content')
    <form method="POST" action="{{URL::to('/changeSchedule')}}">
      <input type="hidden" name="_token" value="{!! csrf_token() !!}">
      <input type="hidden" name="date" value="<?php echo date('Y-m-d');?>"/>
      <label>Department:</label>
      <select class="form-control" name="department">
        @foreach($department_user as $user_department)
          <option value="{{$user_department->department_id}}">{{$user_department->department_name}}</option>
        @endforeach
      </select>
      <hr/>
      <label><u>Date of Effectivity:</u></label><br/>
      <label>From:</label>
      <input type="date" name="dateFromofEffectivity" class="form-control"/>
      <br/>
      <label>To:</label>
      <input type="date" name="dateToofEffectivity" class="form-control"/>
      <hr/>
      <label><u>Shift Schedule:</u></label><br/>
      <label>From:</label>
      <input type="date" name="dateFromShift" class="form-control"/>
      <br/>
      <label>To:</label>
      <input type="date" name="dateToShift" class="form-control"/>
      <hr/>
      <label>Reason:</label>
      <textarea class="form-control" name="reason"></textarea>
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
      <select class="form-control">
          <option value="Rodrigo Duterte">Rodrigo Duterte</option>
          <option value="Erwin Mark Añora">Erwin Mark Añora</option>
          <option value="Will Smith">Will Smith</option>
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

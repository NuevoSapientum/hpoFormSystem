@extends('layout.default')

@section('head')
  <h1>
    Overtime Authorization Slip
  </h1>
@endsection

@section('content')
  <form method="POST" action="overtimeAuthSlip">
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
      <input type="hidden" name="_token" value="{!! csrf_token() !!}">
      <hr/>
      <button type="button" id="dateTime" class="btn btn-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Date/Time</button>
      <input type="hidden" name="number" id="number" value="1" />
      <br/>
      <hr/>
      <label>Schedule: {{date('h:i A', strtotime($shift->shift_from))}} to {{date('h:i A', strtotime($shift->shift_to))}}</label>
      <hr/>
      <div id="datesTime">
        <label>From:</label>
        <input type='date' class='form-control' name='dateFromOvertime' /> <br/>
        <input type='time' class='form-control' name='timeFromOvertime' /><br/>
        <label>To:</label>
        <input type='date' class='form-control' name='dateToOvertime' /> <br/>
        <input type='time' class='form-control' name='timeToOvertime' /><hr/>    
      </div>
      <br/>
      <label>Supervisor Signature:</label>
      <select class="form-control" name="supervisor">
          @foreach($Supervisors as $Supervisor)
            <option value="{{$Supervisor->id}}">{{$Supervisor->emp_name}}</option>
          @endforeach
      </select>
      <label>Detailed Purpose of Overtime:</label>
      <textarea class="form-control" name="purpose"></textarea>
      <br/>
      <hr/>
      
      <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  

@endsection
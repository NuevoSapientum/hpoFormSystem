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
      <hr/>
      <button type="button" id="dateTime" class="btn btn-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Date/Time</button>
      <input type="hidden" id="number" value="0" />
      <br/>
      <input type="hidden" name="_token" value="{!! csrf_token() !!}">
      <input type="hidden" name="dateCreated" value="<?php echo date('Y-m-d');?>"/>
      <br/>
      <div id="datesTime">
        
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

  <script type="text/javascript">

    $("#dateTime").click(function(){
      var value = parseInt(document.getElementById('number').value, 10);
      value = isNaN(value) ? 0 : value;
      value++;
      document.getElementById('number').value = value;
      $("#datesTime").append("<input type='date' class='form-control' name='dateovertime" + value + "' /> <br/>");
      $("#datesTime").append("<input type='time' class='form-control' name='timeovertime" + value + "' /><hr/>");
    });
  </script>
@endsection
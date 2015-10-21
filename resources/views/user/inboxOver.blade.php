@extends('layout.default')

@section('head')
  <h1>
    Edit Overtime Authorization Slip
  </h1>
@endsection

@section('content')
  @foreach($contents as $content)
    <form method="POST" action="{{URL::to('inbox/edit/' . $content->form_id . '/' . $content->id)}}">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <hr/>
        <label>Employee Name:</label>
        <input disabled value="{{$content->users->emp_name}}" class="form-control" />
        <hr/>
        <label>Total Hours: {{$content->total_overtime}}</label>
        <hr/>
        @foreach($dateTime as $dateAndtime)
        <?php $count++ ?>
        <div id="datesTime">
          <label>From:</label>
          <input type='date' class='form-control' name='dateFromOvertime{{$count}}' value="{{$dateAndtime->dateFromOvertime}}"/> <br/>  
          <input type='time' class='form-control' name='timeFromOvertime{{$count}}' value="{{$dateAndtime->timeFromOvertime}}" />
          <br/><label>To:</label>
          <input type='date' class='form-control' name='dateToOvertime{{$count}}' value="{{$dateAndtime->dateToOvertime}}"/> <br/>
          <input type='time' class='form-control' name='timeToOvertime{{$count}}' value="{{$dateAndtime->timeToOvertime}}" /><hr/>  
          
          <input type="hidden" name="count" value="{{$count}}" >
          <input type="hidden" name="id{{$count}}" value="{{$dateAndtime->id}}" >
        </div>
        @endforeach
        <label>Supervisor Signature:</label>
        <select class="form-control" id="supervisor" name="supervisor">
            @foreach($Supervisors as $Supervisor)
              @if($Supervisor->id === $content->permission_id1)
                <option selected="true" value="{{$Supervisor->id}}">{{$Supervisor->emp_name}}</option>
              @else
                <option value="{{$Supervisor->id}}">{{$Supervisor->emp_name}}</option>
              @endif
            @endforeach
        </select><br/>
        <label>Detailed Purpose of Overtime:</label>
        <textarea class="form-control" id="purpose" name="purpose">{{$content->purpose}}</textarea>
        <br/>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  @endforeach
@endsection
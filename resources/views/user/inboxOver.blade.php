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
        <label>Employee Name:</label>
        <input disabled value="{{$content->users->emp_name}}" class="form-control" />
        <br/>
        <label>Date/Time:</label>
        @foreach($dateTime as $dateAndtime)
        <?php $count++ ?>
        <div id="datesTime">
          <input type='date' class='form-control' name='dateOvertime{{$count}}' value="{{$dateAndtime->date_overtime}}"/> <br/>
          <input type='time' class='form-control' name='timeOvertime{{$count}}' value="{{$dateAndtime->time_overtime}}" /><hr/>  
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
        </select>
        <label>Detailed Purpose of Overtime:</label>
        <textarea class="form-control" id="purpose" name="purpose">{{$content->purpose}}</textarea>
        <br/>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  @endforeach
@endsection
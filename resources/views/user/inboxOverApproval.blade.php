@extends('layout.default')

@section('head')
  <h1>
    Edit Overtime Authorization Slip
  </h1>
@endsection

@section('content')
  @foreach($contents as $content)
    <hr/>
    <form method="POST" action="{{URL::to('inbox/edit/' . $content->form_id . '/' . $content->id)}}">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <label>Employee Name:</label>
        <input disabled value="{{$content->users->emp_name}}" class="form-control" />
        <hr/>
        <label>Total Hours: {{$content->total_overtime}}</label><br/>
        <label>Schedule: {{date('h:i A', strtotime($shift->shift_from))}} to {{date('h:i A', strtotime($shift->shift_to))}}</label>
        <hr/>
        @foreach($dateTime as $dateAndtime)
        <div id="datesTime">
          <label>From:</label>
          <input class='form-control' disabled value="{{date('F d, Y', strtotime($dateAndtime->dateFromOvertime))}}"/> <br/>  
          <input type='time' disabled class='form-control'value="{{$dateAndtime->timeFromOvertime}}" />
          <br/><label>To:</label>
          <input class='form-control' disabled value="{{date('F d, Y', strtotime($dateAndtime->dateToOvertime))}}"/> <br/>
          <input type='time' disabled class='form-control' value="{{$dateAndtime->timeToOvertime}}" /><hr/>  
        </div>
        @endforeach
        <label>Supervisor Signature:</label>
        <select class="form-control" disabled >
            @foreach($Supervisors as $Supervisor)
              @if($Supervisor->id === $content->permission_id1)
                <option selected="true" disabled value="{{$Supervisor->id}}">{{$Supervisor->emp_name}}</option>
              @else
                <option disabled value="{{$Supervisor->id}}">{{$Supervisor->emp_name}}</option>
              @endif
            @endforeach
        </select>
        <div class="radio">
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
        </div>
        <br/>
        <label>Detailed Purpose of Overtime:</label>
        <textarea class="form-control" disabled>{{$content->purpose}}</textarea>
        <br/>
        <label>Client Paid:</label>
        <div class="radio">
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
        </div>
        <br/>
        <label>Note:</label>
        <textarea disabled class="form-control">{{$content->reason}}</textarea>
        <hr/>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  @endforeach
@endsection
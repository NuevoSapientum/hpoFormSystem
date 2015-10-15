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
        <br/>
        <label>Employee Name:</label>
        <p>{{$content->users->emp_name}}</p>
        <br/>
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
        <textarea class="form-control" id="reasonforChangeSchedule" name="reasonforChangeSchedule">{{$content->purpose}}</textarea>
        <br/>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  @endforeach
@endsection
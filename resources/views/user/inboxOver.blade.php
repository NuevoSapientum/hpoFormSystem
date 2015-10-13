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
        <label>Client:</label>
        <br/>
        <select class="form-control" name="client">
          @if($content->client_id == 1)
            <option selected="true" value="1">Jay Timbal</option>
            <option value="2">Solis Roltaire</option>
            <option value="3">Jerrymae Noya</option>
          @elseif($content->client_id == 2)
            <option value="1">Jay Timbal</option>
            <option selected="true" value="2">Solis Roltaire</option>
            <option value="3">Jerrymae Noya</option>
          @elseif($content->client_id == 3)
            <option value="1">Jay Timbal</option>
            <option value="2">Solis Roltaire</option>
            <option selected="true" value="3">Jerrymae Noya</option>
          @endif
        </select>
        <br/>
        <label>Detailed Purpose of Overtime:</label>
        <textarea class="form-control" id="reasonforChangeSchedule" name="reasonforChangeSchedule">{{$content->purpose}}</textarea>
        <br/>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  @endforeach
@endsection
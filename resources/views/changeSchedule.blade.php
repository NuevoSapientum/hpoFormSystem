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
          <option value="Human Resource">Human Resource</option>
          <option value="System Engine Optimization">System Engine Optimization</option>
          <option value="Quality Assurance">Quality Assurance</option>
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
      <select class="form-control" name="SPandPM">
          <option value="Solis Roltaire">Solis Roltaire</option>
          <option value="Jay Timbal">Jay Timbal</option>
          <option value="Jerrymae Noya">Jerrymae Noya</option>
      </select>
      <br/>
      <label>Project Manager:</label>
      <select class="form-control" name="SPandPM">
          <option value="Jay Timbal">Jay Timbal</option>
          <option value="Solis Roltaire">Solis Roltaire</option>
          <option value="Jerrymae Noya">Jerrymae Noya</option>
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
      <select class="form-control">
          <option value="Erwin Mark Añora">Erwin Mark Añora</option>
          <option value="Rodrigo Duterte">Rodrigo Duterte</option>
          <option value="Will Smith">Will Smith</option>
      </select>
      <hr/>
      <button type="submit" class="btn btn-primary">Submit</button>
  </form>
@endsection

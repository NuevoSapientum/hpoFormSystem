@extends('layout.default')

@section('head')
  <h1>
    Exit Pass Form
  </h1>
@endsection

@section('content')
  <form method="POST" action="exitForm">
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
      
      <br/>
      <label>From:</label>
      <input id="dateFrom" name="dateFrom" class="form-control"/><br/> 
      <label>To:</label>
      <input id="dateTo" name="dateTo" class="form-control"/><br/>       
      <label>Purpose:</label>
      <textarea class="form-control" name="purpose"></textarea><br/>
      <label>Supervisor Signature:</label>
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
      <br/>
      <label>HR:</label>
      <select class="form-control" name="HR">
          @foreach($HRs as $HR)
            <option value="{{$HR->id}}">{{$HR->emp_name}}</option>
          @endforeach
      </select>
      <br/>
      <label>Company Representative:</label>
      <select class="form-control" name="companyRep">
          @foreach($CompanyReps as $CompanyRep)
            <option value="{{$CompanyRep->id}}">{{$CompanyRep->emp_name}}</option>
          @endforeach
      </select>
      <hr/>
      <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  <script type="text/javascript">
    var $fpf = $( "#dateFrom" ),
        now = moment( ).subtract( "seconds", 1 );
    $fpf.filthypillow( { 
      minDateTime: function( ) {
        return now;
      } 
    } );
    $fpf.on( "focus", function( ) {
      $fpf.filthypillow( "show" );
    } );
    $fpf.on( "fp:save", function( e, dateObj ) {
      $fpf.val( dateObj.format( "MMM DD YYYY hh:mm A" ) );
      $fpf.filthypillow( "hide" );
    } );

    var $fp = $( "#dateTo" ),
        now = moment( ).subtract( "seconds", 1 );
    $fp.filthypillow( { 
      minDateTime: function( ) {
        return now;
      } 
    } );
    $fp.on( "focus", function( ) {
      $fp.filthypillow( "show" );
    } );
    $fp.on( "fp:save", function( e, dateObj ) {
      $fp.val( dateObj.format( "MMM DD YYYY hh:mm A" ) );
      $fp.filthypillow( "hide" );
    } );
  </script>
@endsection
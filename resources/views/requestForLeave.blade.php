@extends('layout.default')

@section('head')
  <h1>
    Request for Leave of Absence
  </h1>
@endsection

@section('content')
    <form method="POST" action="requestForLeave">
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
      <input type="hidden" name="dateCreated" value="<?php echo date('Y-m-d');?>"/>
      <hr/>
      <label>Type of Leave:</label>
      <br/>
      <div class="radio">
        <label><input type="radio" name="typeofLeave" checked="checked" value="1" />Vacation Leave</label>
        <label><input type="radio" name="typeofLeave" value="2" />Sick Leave </label>
        <label><input type="radio" name="typeofLeave" value="3" />Maternity Leave </label>
        <label><input type="radio" name="typeofLeave" value="4" />Paternity Leave </label>
      </div>
      
      <br/>
      <label>Reason(s) for Absence:</label>
      <textarea class="form-control" name="reason"></textarea>
      <br/>
      <label>Recommending Approval:</label>
      <select class="form-control" name="recommendApproval">
          @foreach($permissioners as $permissioner)
            <option value="{{$permissioner->id}}">{{$permissioner->emp_name}}</option>
          @endforeach
      </select>
      <br/>
      <label>Approved by:</label>
      <select class="form-control" name="approvedBy">
          @foreach($permissioners as $permissioner)
            <option value="{{$permissioner->id}}">{{$permissioner->emp_name}}</option>
          @endforeach
      </select><br/>
      <table>
        <!-- Inclusive Dates of Leave -->
      </table>
      <label>Entitlement:</label> 
      <input type="text" class="form-control" name="entitlement" disabled="true" value="{{Auth::user()->entitlement}} Days" /><br/>
      <label>Days Already Taken:</label> 
      <input type="text" class="form-control" disabled="true" value="{{Auth::user()->days_taken}}"/><br/>
      <label>Days Applied For:</label> 
      <br/>
      <select class="form-control" name="days_applied">
        {{$balance = Auth::user()->entitlement - Auth::user()->days_taken}}
        @if($balance == 0)
          <option value="0">No days left</option>
        @else
          @for($i = 1; $i <= $balance = Auth::user()->entitlement - Auth::user()->days_taken; $i++)
            @if($i == 1)
              <option value="{{$i}}">{{$i}} Day</option>
            @else
              <option value="{{$i}}">{{$i}} Days</option>
            @endif
          @endfor
        @endif
      </select><br/>
      <label>Balance:</label> 
      <input type="text" class="form-control" disabled value="{{$balance}}"/><br/>
      <button type="submit" class="btn btn-primary">Submit</button>
  </form>
@endsection
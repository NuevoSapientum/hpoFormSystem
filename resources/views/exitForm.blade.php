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
      <input type="hidden" name="dateCreated" value="<?php echo date('Y-m-d');?>"/>
      <hr/>
      <label>Department:</label>
      <!-- <select class="form-control" name="department">
          <option value="Human Resource">Human Resource</option>
          <option value="System Engine Optimization">System Engine Optimization</option>
          <option value="Quality Assurance">Quality Assurance</option>
      </select> -->
      <select class="form-control" name="department">
        @foreach($department_user as $user_department)
          <option value="{{$user_department->department_id}}">{{$user_department->department_name}}</option>
        @endforeach
      </select>
      
      <br/>
      <label>From:</label>
      <input type="date" id="fromDate" name="dateFrom" class="form-control"/><br/> 
      <label>To:</label>
      <input type="date" id="toDate" name="dateTo" class="form-control"/><br/>       
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
@endsection
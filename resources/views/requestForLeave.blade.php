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
        <label><input type="radio" name="typeofLeave" id="VL" value="1" />Vacation Leave</label>
        <label><input type="radio" name="typeofLeave" id="SL" value="2" />Sick Leave </label>
        <label><input type="radio" name="typeofLeave" id="ML" value="3" />Maternity Leave </label>
        <label><input type="radio" name="typeofLeave" id="PL" value="4" />Paternity Leave </label>
      </div>
        
        <div id="VLShow">
          <?php $balance = Auth::user()->VL_entitlement - Auth::user()->VL_taken ?>
          <label>Vacation Leave Entitlement:</label> 
          <input type="text" class="form-control" name="VL" disabled value="{{Auth::user()->VL_entitlement}} Days" /><br/>
          <label>Days Already Taken:</label> 
          <input type="text" class="form-control" disabled value="{{Auth::user()->VL_taken}}"/><br/>
          <label>Days Applied For:</label> 
          <input type="number" class="form-control" name="days_applied" value="0" />
          <br/>
          <label>Balance:</label> 
          <input type="text" class="form-control" disabled value="{{$balance}}"/><br/>
        </div>  

        <div id="SLShow">
          <?php $balance = Auth::user()->SL_entitlement - Auth::user()->SL_taken ?>
          <label>Sick Leave Entitlement:</label> 
          <input type="text" class="form-control" name="SL" disabled value="{{Auth::user()->SL_entitlement}} Days" /><br/>
          <label>Days Already Taken:</label> 
          <input type="text" class="form-control" disabled value="{{Auth::user()->SL_taken}}"/><br/>
          <label>Days Applied For:</label> 
          <input type="number" class="form-control" name="days_applied" value="0" />
          <br/>
          <label>Balance:</label> 
          <input type="text" class="form-control" disabled value="{{$balance}}"/><br/>
        </div>

        <div id="MLShow">
          <?php $balance = Auth::user()->ML_entitlement - Auth::user()->ML_taken ?>
          <label>Maternal Leave Entitlement:</label> 
          <input type="text" class="form-control" name="ML" disabled value="{{Auth::user()->ML_entitlement}} Days" /><br/>
          <label>Days Already Taken:</label> 
          <input type="text" class="form-control" disabled value="{{Auth::user()->ML_taken}}"/><br/>
          <label>Days Applied For:</label> 
          <input type="number" class="form-control" name="days_applied" value="0" />
          <br/>
          <label>Balance:</label> 
          <input type="text" class="form-control" disabled value="{{$balance}}"/><br/>
        </div>

        <div id="PLShow">
          <?php $balance = Auth::user()->PL_entitlement - Auth::user()->PL_taken ?>
          <label>Paternal Leave Entitlement:</label> 
          <input type="text" class="form-control" name="PL" disabled value="{{Auth::user()->PL_entitlement}} Days" /><br/>
          <label>Days Already Taken:</label> 
          <input type="text" class="form-control" disabled value="{{Auth::user()->PL_taken}}"/><br/>
          <label>Days Applied For:</label> 
          <input type="number" class="form-control" name="days_applied" value="0" />
          <br/>
          <label>Balance:</label> 
          <input type="text" class="form-control" disabled value="{{$balance}}"/><br/>
        </div>
        
      <br/>
      <label>Reason(s) for Absence:</label>
      <textarea class="form-control" name="reasonforAbsence"></textarea>
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
      <button type="submit" class="btn btn-primary">Submit</button>
  </form>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#VLShow').attr('style', 'display:none');
      $('#SLShow').attr('style', 'display:none');
      $('#MLShow').attr('style', 'display:none');
      $('#PLShow').attr('style', 'display:none');
       $('input[type="radio"]').click(function() {
          // alert($(this).attr('id') == 'permission_2no');
           if($(this).attr('id') == 'VL') {
                $('#VLShow').attr('style', 'display:');
                $('#SLShow').attr('style', 'display:none');
                $('#MLShow').attr('style', 'display:none');
                $('#PLShow').attr('style', 'display:none');
           }else if($(this).attr('id') == 'SL'){
                $('#SLShow').attr('style', 'display:');
                $('#VLShow').attr('style', 'display:none');
                $('#MLShow').attr('style', 'display:none');
                $('#PLShow').attr('style', 'display:none');
           }else if($(this).attr('id') == 'ML'){
                $('#MLShow').attr('style', 'display:');
                $('#VLShow').attr('style', 'display:none');
                $('#SLShow').attr('style', 'display:none');
                $('#PLShow').attr('style', 'display:none');
           }else if($(this).attr('id') == 'PL'){
                $('#PLShow').attr('style', 'display:');
                $('#VLShow').attr('style', 'display:none');
                $('#SLShow').attr('style', 'display:none');
                $('#MLShow').attr('style', 'display:none');
           }else{
                $('#VLShow').attr('style', 'display:none');
                $('#SLShow').attr('style', 'display:none');
                $('#MLShow').attr('style', 'display:none');
                $('#PLShow').attr('style', 'display:none');
           }
       });
    });
    
  </script>
@endsection
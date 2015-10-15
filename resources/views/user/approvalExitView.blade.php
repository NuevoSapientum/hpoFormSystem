@extends('layout.default')

@section('head')
	<h1>Need Approval Exit Pass</h1>
@endsection

@section('content')
	@if (count($errors) > 0)
    <div class="alert alert-danger">
    There were some problems editing your profile:
    <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>
    @endif
    @foreach($contents as $content)

	<form method="POST" id="approvalExit" action="{{URL::to('approval/view/' . $content->form_id . '/' . $content->id)}}" name="editProfile" enctype="multipart/form-data">
		<hr/>
		<input type="hidden" name="_token" value="{!! csrf_token() !!}">
		<?php 
			$date_from = date('M d Y h:i A',strtotime($content->date_from));
			$date_to = date('M d Y h:i A', strtotime($content->date_to));
		?>
		<label>Employee Name:</label>
      	<p>{{$content->users->emp_name}}</p>
		<label>From:</label>
	    <input disabled="true" value="{{$date_from}}" class="form-control"/><br/> 
	    <label>To:</label>
	    <input disabled="true" value="{{$date_to}}" class="form-control"/><br/>       
	    <label>Purpose:</label>
	    <textarea disabled="true" class="form-control">{{$content->purpose}}</textarea><br/>
	    <label>Supervisor Signature:</label>
	      @foreach($Supervisors as $Supervisor)
	      	@if($Supervisor->id === $content->permission_id1)
	          	<input disabled="true" class="form-control" value="{{$Supervisor->emp_name}}" />
	      	@endif
	      @endforeach
	      <div class="radio">
	      	@if($content->permission_2 === 0 && $content->permission_id1 === Auth::user()->id)
	      		@if($content->permission_1 === 1)
			        <label><input type="radio" disabled checked="true"/>Yes</label>
			        <label><input type="radio" disabled />No</label>
		        @elseif($content->permission_1 === 2)
		        	<label><input type="radio" id="permission_1yes" name="permission_1" value="1" />Yes</label>
			        <label><input type="radio" id="permission_1no" name="permission_1" checked="true" value="2" />No</label>
			    @else
			    	<label><input type="radio" id="permission_1yes" name="permission_1" value="1" />Yes</label>
	              	<label><input type="radio" id="permission_1no" name="permission_1" value="2" />No</label>
			    @endif
	      	
		    @else
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
		    @endif
	      </div>
	      <br/>
      	<label>Project Manager:</label>
          @foreach($PMs as $PM)
          	@if($PM->id === $content->permission_id2)
	            <input disabled="true" class="form-control" value="{{$PM->emp_name}}" />
	        @endif
          @endforeach
          <div class="radio">
	        @if($content->permission_1 === 1 && Auth::user()->id === $content->permission_id2)
	      		@if($content->permission_2 === 1)
			        <label><input type="radio" disabled checked="true"/>Yes</label>
			        <label><input type="radio" disabled />No</label>
		        @elseif($content->permission_2 === 2)
		        	<label><input type="radio" id="permission_2yes" name="permission_2" value="1" />Yes</label>
			        <label><input type="radio" id="permission_2no" name="permission_2" checked="true" value="2" />No</label>
			    @else
			    	<label><input type="radio" id="permission_2yes" name="permission_2" value="1" />Yes</label>
	              	<label><input type="radio" id="permission_2no" name="permission_2" value="2" />No</label>
			    @endif
		    @else
		    	@if($content->permission_2 === 1)
		    	<label><input type="radio" checked="true" disabled />Yes</label>
              	<label><input type="radio" disabled />No</label>
		    	@elseif($content->permission_2 === 2)
		    	<label><input type="radio" disabled />Yes</label>
              	<label><input type="radio" checked="true" disabled />No</label>
              	@else
              	<label><input type="radio" disabled />Yes</label>
              	<label><input type="radio" disabled />No</label>
              	@endif
		    @endif
	      </div>
	      <br/>
	    <label>HR:</label>
	      	@foreach($HRs as $HR)
	      		@if($HR->id === $content->permission_id3)
	      			<input disabled="true" class="form-control" value="{{$HR->emp_name}}" />
	            @endif
	          @endforeach
	      <div class="radio">
	        @if($content->permission_2 === 1 && Auth::user()->id === $content->permission_id3)
	      		@if($content->permission_3 === 1)
			        <label><input type="radio" disabled checked="true" name="permission_3" value="1" />Yes</label>
			        <label><input type="radio" disabled name="permission_3" value="2" />No</label>
		        @elseif($content->permission_3 === 2)
		        	<label><input type="radio" id="permission_3yes" name="permission_3" value="1" />Yes</label>
			        <label><input type="radio" id="permission_3no" name="permission_3" checked="true" value="2" />No</label>
			    @else
			    	<label><input type="radio" id="permission_3yes" name="permission_3" value="1" />Yes</label>
	              	<label><input type="radio" id="permission_3no" name="permission_3" value="2" />No</label>
			    @endif
		    @else
		    	@if($content->permission_3 === 1)
		    	<label><input type="radio" checked="true" disabled />Yes</label>
              	<label><input type="radio" disabled />No</label>
		    	@elseif($content->permission_3 === 2)
		    	<label><input type="radio" disabled />Yes</label>
              	<label><input type="radio" checked="true" disabled />No</label>
              	@else
              	<label><input type="radio" disabled />Yes</label>
              	<label><input type="radio" disabled />No</label>
              	@endif
		    @endif
	      </div>
	      <br/>
      	<label>Company Representative:</label>
	          @foreach($CompanyReps as $CompanyRep)
	          	@if($CompanyRep->id === $content->permission_id4)
	          		<input disabled="true" class="form-control" value="{{$CompanyRep->emp_name}}"/>
	          	@endif
	          @endforeach
          <div class="radio">
	        @if($content->permission_3 === 1 && Auth::user()->id === $content->permission_id4)
	      		@if($content->permission_4 === 1)
			        <label><input type="radio" disabled checked="true" />Yes</label>
			        <label><input type="radio" disabled />No</label>
		        @elseif($content->permission_4 === 2)
		        	<label><input type="radio" name="permission_4" value="1" />Yes</label>
			        <label><input type="radio" name="permission_4" checked="true" value="2" />No</label>
			    @else
			    	<label><input type="radio" id="permission_4yes" name="permission_4" value="1" />Yes</label>
	              	<label><input type="radio" id="permission_4no" name="permission_4" value="2" />No</label>
			    @endif
		    @else
		    	@if($content->permission_4 === 1)
		    	<label><input type="radio" checked="true" disabled />Yes</label>
              	<label><input type="radio" disabled />No</label>
		    	@elseif($content->permission_4 === 2)
		    	<label><input type="radio" disabled />Yes</label>
              	<label><input type="radio" checked="true" disabled />No</label>
              	@else
              	<label><input type="radio" disabled />Yes</label>
              	<label><input type="radio" disabled />No</label>
              	@endif
		    @endif
	      </div>
        @if($content->permission_1 == 2 || $content->permission_2 == 2 || $content->permission_3 == 2
        	|| $content->permission_4 == 2)
        	<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
	          <div class="modal-dialog" role="document">
	            <div class="modal-content">
	              <div class="modal-header">
	                <h4>Note:</h4>
	              </div>
	              <div class="modal-body">
	                <textarea class="form-control" id="note" name="note">{{$content->reason}}</textarea>
	              </div>
	              <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	                <button type="submit" class="btn btn-primary">Save changes</button>
	              </div>
	            </div>
	          </div>
	        </div>
			<button type="button" id="submit" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Save</button>
		@else
			<div class="modal fade" id="false" role="dialog" aria-labelledby="myModalLabel">
	          <div class="modal-dialog" role="document">
	            <div class="modal-content">
	              <div class="modal-header">
	                <h4>Note:</h4>
	              </div>
	              <div class="modal-body">
	                <textarea class="form-control" id="note" name="note" placeholder="Your Note Please:"></textarea>
	              </div>
	              <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	                <button type="submit" class="btn btn-primary">Save changes</button>
	              </div>
	            </div>
	          </div>
	        </div>
		<button type="submit" id="submit" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Save</button>
		@endif
	</form>
	<script>
	$(document).ready(function() {
		// alert('{{$content->exitNote}}')
       $('input[type="radio"]').click(function() {
          // alert($(this).attr('id') == 'permission_2no');
           if($(this).attr('id') == 'permission_1no' || $(this).attr('id') == 'permission_2no' 
                || $(this).attr('id') == 'permission_3no' || $(this).attr('id') == 'permission_4no') {
                $('#false').attr('id', 'myModal');
                $('#submit').attr('type', 'button');
                $('#note').prop('required', true);
           }else {
                $('#myModal').attr('id', 'false');
                $('#submit').attr('type', 'submit');
                $('#note').prop('required', false);
           }
       });
    });
	
    </script>
	@endforeach
@endsection
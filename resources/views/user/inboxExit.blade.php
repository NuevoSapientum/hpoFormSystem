@extends('layout.default')

@section('head')
	<h1>Edit Form</h1>
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
	<form method="POST" action="{{URL::to('inbox/edit/' . $content->form_type . '/' . $content->tbl_epid)}}" name="editProfile" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{!! csrf_token() !!}">
		<label>From:</label>
	    <input type="date" id="fromDate" name="dateFrom" value="{{$content->dateFrom}}" class="form-control"/><br/> 
	    <label>To:</label>
	    <input type="date" id="toDate" name="dateTo" value="{{$content->dateTo}}" class="form-control"/><br/>       
	    <label>Purpose:</label>
	    <textarea class="form-control" id="textArea" name="textPurpose"></textarea><br/>
	    <label>Supervisor Signature:</label>
	      <select class="form-control" id="supervisor" name="supervisor">
	          @foreach($Supervisors as $Supervisor)
	          	@if($Supervisor === $content->permission_id1)
		          	<option selected="true" value="{{$Supervisor->id}}">{{$Supervisor->emp_name}}</option>
	          	@else
		            <option value="{{$Supervisor->id}}">{{$Supervisor->emp_name}}</option>
	          	@endif
	          @endforeach
	      </select>
	      <br/>
	      <label>Project Manager:</label>
	      <select class="form-control" id="projectManager" name="projectManager">
	          @foreach($PMs as $PM)
	          	@if($PM->id === $content->permission_id2)
		            <option selected="true" value="{{$PM->id}}">{{$PM->emp_name}}</option>
	          	@else
	          		<option value="{{$PM->id}}">{{$PM->emp_name}}</option>
	          	@endif
	          @endforeach
	      </select>
	      <br/>
	      <label>HR:</label>
	      <select class="form-control" id="HR" name="HR">
	      	@foreach($HRs as $HR)
	      		@if($HR->id === $content->permission_id3)
	      			<option selected="true" value="{{$HR->id}}">{{$HR->emp_name}}</option>
	      		@else
	            	<option value="{{$HR->id}}">{{$HR->emp_name}}</option>
	            @endif
	          @endforeach
	      </select>
	      <br/>
	      <label>Company Representative:</label>
	      <select class="form-control" id="companyRep" name="companyRep">
	          @foreach($CompanyReps as $CompanyRep)
	          	@if($CompanyRep->id === $content->permission_id4)
	          		<option selected="true" value="{{$CompanyRep->id}}">{{$CompanyRep->emp_name}}</option>
	          	@else
		            <option value="{{$CompanyRep->id}}">{{$CompanyRep->emp_name}}</option>
	          	@endif
	          @endforeach
	      </select>
	      <hr/>
		<button type="submit" name="submit" class="btn btn-primary">Save</button>
	</form>
	<script type="text/javascript">
			document.getElementById('textArea').value = "{{$content->textPurpose}}";
			if({{$content->status}} === 1){
				// getElementsByName('dateFrom').disabled = "true";
				document.getElementById('fromDate').disabled = true;
				document.getElementById('toDate').disabled = true;
				document.getElementById('textArea').disabled = true;
				document.getElementById('supervisor').disabled = true;
				document.getElementById('projectManager').disabled = true;
				document.getElementById('HR').disabled = true;
				document.getElementById('companyRep').disabled = true;
			}
	</script>
	@endforeach
@endsection
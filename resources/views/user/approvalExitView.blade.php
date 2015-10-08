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

	<form method="POST" id="approvalExit" action="{{URL::to('approval/view/' . $content->form_type . '/' . $content->tbl_epid)}}" name="editProfile" enctype="multipart/form-data">
		<hr/>
		<input type="hidden" name="_token" value="{!! csrf_token() !!}">
		<label>From:</label>
	    <input type="date" disabled="true" id="fromDate" name="dateFrom" value="{{$content->dateFrom}}" class="form-control"/><br/> 
	    <label>To:</label>
	    <input type="date" disabled="true" id="toDate" name="dateTo" value="{{$content->dateTo}}" class="form-control"/><br/>       
	    <label>Purpose:</label>
	    <textarea disabled="true" class="form-control" id="textArea" name="textPurpose">{{$content->textPurpose}}</textarea><br/>
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
	                <textarea class="form-control" id="note" name="note">{{$content->exitNote}}</textarea>
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
	// $('button').click(function(){
	// 	if($('input:radio[name=permission_2]:checked').val() == 1){
	// 		$('#submit').attr("",);
	// 	}else if($('input:radio[name=permission_2]:checked').val() == 2){
	// 		$('#submit').attr({
	// 			data-target: "#myModal",
	// 			data-toggle: "modal"
	// 		});
	// 	}
	// });
	// alert($('input[permission_2]:checked', 'approvalExit').val());
	//Check if the permissioner first clicked yes
 //      var clientId = '862357115869-nmcsojlu77uu0gsig6e8hsncpo4oavic.apps.googleusercontent.com';

 //      if (!/^([0-9])$/.test(clientId[0])) {
 //        alert('Invalid Client ID - did you forget to insert your application Client ID?');
 //      }
 //      // Create a new instance of the realtime utility with your client ID.
 //      var realtimeUtils = new utils.RealtimeUtils({ clientId: clientId });

 //      authorize();

 //      function authorize() {
 //        // Attempt to authorize
 //        realtimeUtils.authorize(function(response){
 //          if(response.error){
 //            // Authorization failed because this is the first time the user has used your application,
 //            // show the authorize button to prompt them to authorize manually.
 //            var button = document.getElementById('auth_button');
 //            button.classList.add('visible');
 //            button.addEventListener('click', function () {
 //              realtimeUtils.authorize(function(response){
 //                start();
 //              }, true);
 //            });
 //          } else {
 //              start();
 //          }
 //        }, false);
 //      }

 //      function start() {
 //        // With auth taken care of, load a file, or create one if there
 //        // is not an id in the URL.
 //        var id = realtimeUtils.getParam('id');
 //        if (id) {
 //          // Load the document id from the URL
 //          realtimeUtils.load(id.replace('/', ''), onFileLoaded, onFileInitialize);
 //        } else {
 //          // Create a new document, add it to the URL
 //          realtimeUtils.createRealtimeFile('New Quickstart File', function(createResponse) {
 //            window.history.pushState(null, null, '?id=' + createResponse.id);
 //            realtimeUtils.load(createResponse.id, onFileLoaded, onFileInitialize);
 //          });
 //        }
 //      }

 //      // The first time a file is opened, it must be initialized with the
 //      // document structure. This function will add a collaborative string
 //      // to our model at the root.
 //      function onFileInitialize(model) {
 //        var string = model.createString();
 //        string.setText('Welcome to the Quickstart App!');
 //        model.getRoot().set('demo_string', string);
 //      }

 //      // After a file has been initialized and loaded, we can access the
 //      // document. We will wire up the data model to the UI.
 //      function onFileLoaded(doc) {
 //        var collaborativeString = doc.getModel().getRoot().get('demo_string');
 //        wireTextBoxes(collaborativeString);
 //      }

 //      // Connects the text boxes to the collaborative string
 //      function wireTextBoxes(collaborativeString) {
 //        var textArea1 = document.getElementById('text_area_1');
 //        var textArea2 = document.getElementById('text_area_2');
 //        gapi.drive.realtime.databinding.bindString(collaborativeString, textArea1);
 //        gapi.drive.realtime.databinding.bindString(collaborativeString, textArea2);
 //      }
    </script>
	@endforeach
@endsection
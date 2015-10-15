@extends('layout.default')

@section('head')
	<h1>Exit Pass</h1>
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

	<form method="POST" id="approvalExit" name="editProfile" enctype="multipart/form-data">
		<hr/>
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
	      </div>
	      <br/>
      	<label>Project Manager:</label>
          @foreach($PMs as $PM)
          	@if($PM->id === $content->permission_id2)
	            <input disabled="true" class="form-control" value="{{$PM->emp_name}}" />
	        @endif
          @endforeach
          <div class="radio">
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
	      </div>
	      <br/>
	    <label>HR:</label>
	      	@foreach($HRs as $HR)
	      		@if($HR->id === $content->permission_id3)
	      			<input disabled="true" class="form-control" value="{{$HR->emp_name}}" />
	            @endif
	          @endforeach
	      <div class="radio">
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
	      </div>
	      <br/>
      	<label>Company Representative:</label>
	          @foreach($CompanyReps as $CompanyRep)
	          	@if($CompanyRep->id === $content->permission_id4)
	          		<input disabled="true" class="form-control" value="{{$CompanyRep->emp_name}}"/>
	          	@endif
	          @endforeach
          <div class="radio">
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
	      </div>
	      <br/>
	      <label>Note:</label>
	      <textarea disabled class="form-control">{{$content->reason}}</textarea>
		<hr/>
	</form>
	<script>
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
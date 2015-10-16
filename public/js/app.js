// $(document).ready(function(){
// 		$(function(){
// 			$("#file").change(function(){
// 				var reader = new FileReader();
// 				reader.onload = function(e){
// 					$('#preview').attr("style", "height:100px;width: 100px");
// 					$('#preview').attr('src', e.target.result);
// 				}
// 				reader.readAsDataURL(this.files[0]);
// 			});
// 		});
// 	});

function goBack() {
    window.history.back();
}

$(document).ready(function() {
  $('#example-getting-started').multiselect();
  $('#example-single').multiselect();
  $('#example-multiple-selected').multiselect();
  $('#example-multiple-optgroups').multiselect();
  $('#multiselect').multiselect();
  $('#multiselect-group').multiselect({
    includeSelectAllOption: false,
    buttonClass: 'form-control'
  });

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
  
    if($('#VL').is(':checked')){
      $('#VLShow').attr('style', 'display:');
      $('#SLShow').attr('style', 'display:none');
      $('#MLShow').attr('style', 'display:none');
      $('#PLShow').attr('style', 'display:none');
    }else if($('#SL').is(':checked')){
      $('#VLShow').attr('style', 'display:none');
      $('#SLShow').attr('style', 'display:');
      $('#MLShow').attr('style', 'display:none');
      $('#PLShow').attr('style', 'display:none');
    }else if($('#ML').is(':checked')){
      $('#VLShow').attr('style', 'display:none');
      $('#SLShow').attr('style', 'display:none');
      $('#MLShow').attr('style', 'display:');
      $('#PLShow').attr('style', 'display:none');
    }else if($('#PL').is(':checked')){
      $('#VLShow').attr('style', 'display:none');
      $('#SLShow').attr('style', 'display:none');
      $('#MLShow').attr('style', 'display:none');
      $('#PLShow').attr('style', 'display:');
    }
  

  $("#dateTime").click(function(){
    var value = parseInt(document.getElementById('number').value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    document.getElementById('number').value = value;
    $("#datesTime").append("<input type='date' class='form-control' name='dateovertime" + value + "' /> <br/>");
    $("#datesTime").append("<input type='time' class='form-control' name='timeovertime" + value + "' /><hr/>");
  });

  $('input[type="radio"]').click(function() {
          // alert($(this).attr('id') == 'permission_2no');
           if($(this).attr('id') == 'permission_1no' || $(this).attr('id') == 'permission_2no') {
                $('#false').attr('id', 'myModal');
                $('#submit').attr('type', 'button');
           }else {
                $('#myModal').attr('id', 'false');
                $('#submit').attr('type', 'submit');
           }
       });
});

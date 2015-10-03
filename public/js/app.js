$(document).ready(function(){
		$(function(){
			$("#file").change(function(){
				var reader = new FileReader();
				reader.onload = function(e){
					$('#preview').attr("style", "height:100px;width: 100px");
					$('#preview').attr('src', e.target.result);
				}
				reader.readAsDataURL(this.files[0]);
			});
		});
	});

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
});
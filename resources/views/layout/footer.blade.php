      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2015 <a href="http://www.hpoutsourcinginc.com/">HP Outsourcing Inc.</a></strong> All rights reserved.
      </footer>
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.4 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="bootstrap/js/bootstrap-multiselect.js"></script>
    <script>
    
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
// /*multimple selected width 100%*/
// $('#example-multiple-selected').multiselect({
//   includeSelectAllOption: false,
//   buttonClass: 'form-control'
// });

// /*started width 100%*/
// $('#example-getting-started').multiselect({
//   includeSelectAllOption: false,
//   buttonWidth: '100%'
// });

// /*single width 100%*/
// $('#example-single').multiselect({
//   includeSelectAllOption: false,
//   buttonWidth: '100%'
// });

// /*multiple option groups width 100%*/
// $('#example-multiple-optgroups').multiselect({
//   includeSelectAllOption: false,
//   buttonWidth: '100%'
// });
    </script>
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. Slimscroll is required when using the
         fixed layout. -->
  </body>
  </body>
</html>

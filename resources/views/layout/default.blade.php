<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="https://www.gstatic.com/realtime/quickstart-styles.css" rel="stylesheet" type="text/css"/>

    <!-- Load the Realtime JavaScript library -->
    <script src="https://apis.google.com/js/api.js"></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('plugins/filthypillow/jquery.filthypillow.css')}}">
    <!-- Load the utility library -->
    <script src="https://www.gstatic.com/realtime/realtime-client-utils.js"></script>
    <!-- Bootstrap 3.3.4 -->
    <link rel="stylesheet" href="{{URL::asset('bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="{{URL::asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('bootstrap/css/bootstrap-multiselect.css')}}" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{URL::asset('dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <script src="{{URL::asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <link rel="stylesheet" href="{{URL::asset('dist/css/skins/skin-blue.min.css')}}">
   <script src="{{URL::asset('plugins/filthypillow/jquery.filthypillow.min.js')}}"></script>
    <script src="{{URL::asset('plugins/filthypillow/moment.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/main.css')}}">
    <script src="{{URL::asset('js/main.js')}}"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="{{URL::to('/dashboard')}}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>HPO</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg" style="font-size:15px" ><b><img src="{{URL::asset('img/logo.png')}}"  style="height: 40px;width: 50px;" id="hpoLogo">
          HP Outsourcing Inc.</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Notifications Menu-->
              <!-- <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">0</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 1 notifications</li>
                  <li>
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i>
                        </a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li> -->
              </li>
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  @while($row = mysqli_fetch_array($profileImage))
                    @if($row[1] == "blank")
                      <img src="{{URL::asset('img/user.png')}}" class="user-image" alt="User Image">
                    @else
                      <img class="user-image" src="data:image;base64, {{$row[2]}} " alt="User Image">
                    @endif
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs">{{ Auth::user()->emp_name }}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    @if($row[1] == "blank")
                    <img src="{{URL::asset('img/user.png')}}" class="img-circle" alt="User Image">
                    @else
                      <img class="img-circle" src="data:image;base64, {{$row[2]}} " alt="User Image">
                    @endif


                    <p>
                      {{ Auth::user()->emp_name }} - @foreach($positions as $position)
                                                      {{ $position->position_name }}
                                                     @endforeach
                      <small>Member since <?php $date = Auth::user()->created_at; echo date('F j, Y', strtotime($date));?></small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                    @if(Auth::user()->permissioners != 0)
                    <div class="col-xs-4 text-center">
                      <a href="{{URL::to('/inbox')}}">Inbox&nbsp;<span class="label label-default">{{$inboxNotif}}</span></a>
                    </div>
                    <div class="col-xs-3"></div>
                    <div class="col-xs-4 text-center">
                      <a href="{{URL::to('/approval')}}">Approvals&nbsp;<span class="label label-default">{{$approvalNotif}}</span></a>
                    </div>
                    @elseif($empDepartment->department_name == "Human Resource")
                      <div class="col-xs-3 text-center">
                        <a href="{{URL::to('/inbox')}}">Inbox&nbsp;<span class="label label-default">{{$inboxNotif}}</span></a>
                      </div>
                      <div class="col-xs-5 text-center">
                        <a href="{{URL::to('/approval')}}">Approvals&nbsp;<span class="label label-default">{{$approvalNotif}}</span></a>
                      </div>
                      <div class="col-xs-4 text-center">
                        <a href="{{URL::to('/submittedforms')}}">Forms&nbsp;<span class="label label-default">{{$count}}</span></a>
                      </div>
                    @else
                    <!-- <div class="col-xs-12 text-center">
                      <a href="{{URL::to('/inbox')}}">Inbox&nbsp;<span class="label label-default">{{$inboxNotif}}</span></a>
                    </div> -->
                    <a href="{{URL::to('/inbox')}}" class="btn btn-default btn-flat" style="height:40px;padding-top:7px;">Inbox&nbsp;<span class="label label-default">{{$inboxNotif}}</span></a>
                    @endif
                    
                    @if($empDepartment->department_name == "Human Resource")
                    
                    
                    @endif
                  </li>
                  @if($empDepartment->department_name == "Human Resource")
                  <li class="user-body">
                    <a href="{{URL::to('auth/register')}}" class="btn btn-default btn-flat" style="height:40px;padding-top:7px;">Create Account</a><br/>
                    <a href="{{URL::to('accounts')}}" class="btn btn-default btn-flat" style="height:40px;padding-top:7px;">Manage Accounts</a>
                  </li>
                  @endif
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{URL::to('/editProfile')}}" class="btn btn-default btn-flat">Edit Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{URL::to('/auth/logout')}}" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>


      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              @if($row[1] == "blank")
              <img src="{{URL::asset('img/user.png')}}" class="img-circle" alt="User Image">
              @else
                <img class="img-circle" src="data:image;base64, {{$row[2]}} " alt="User Image">
              @endif
              @endwhile
            </div>
            <div class="pull-left info">
              <p>{{ Auth::user()->emp_name }}</p>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">Welcome {{ Auth::user()->emp_name }}</li>
            <!-- Optionally, you can add icons to the links -->
            @if($title == 'Home')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{URL::to('/dashboard')}}"><i class="glyphicon glyphicon-home"></i> <span>Home</span></a></li>

            @if($title == 'History')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{URL::to('/history')}}"><i class="glyphicon glyphicon-list-alt"></i> <span>History</span></a></li>  

            @if($empDepartment->department_name == "Human Resource")
              @if($title == 'Vacation Leave' || $title == 'Sick Leave' || $title == 'Maternal Leave' || $title == 'Paternal Leave')
              <li class="treeview active">
              @else
              <li class="treeview">
              @endif
                <a href="#"><i class="glyphicon glyphicon-folder-open"></i> <span>Records of Leave</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="{{URL::to('record/vacation')}}">Vacation Leave</a></li>
                  <li><a href="{{URL::to('record/sick')}}">Sick Leave</a></li>
                  <li><a href="{{URL::to('record/maternal')}}">Maternal Leave</a></li>
                  <li><a href="{{URL::to('record/paternal')}}">Paternal Leave</a></li>
                </ul>
              </li>
            @endif

            @if($title == 'Exit Pass' || $title == 'Request for Leave of Absence' || $title == 'Change Schedule' || $title == 'Overtime Authorization Slip')
            <li class="treeview active">
            @else
            <li class="treeview">
            @endif
              <a href="#"><i class="glyphicon glyphicon-envelope"></i> <span>Form</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{URL::to('/exitForm')}}">Exit Pass</a></li>
                <li><a href="{{URL::to('/requestForLeave')}}">Request for Leave of Absence</a></li>
                <li><a href="{{URL::to('/changeSchedule')}}">Change Schedule Form</a></li>
                <li><a href="{{URL::to('/overtimeAuthSlip')}}">Overtime Authorization Slip</a></li>
              </ul>
            </li>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">
          @yield('head')
        </section>
        <section class="content">
          @yield('content')
        </section>
      </div>

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
    <script src="{{URL::asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <script src="{{URL::asset('plugins/craftpip/jquery-confirm.min.js')}}"></script>
    <!-- Bootstrap 3.3.4 -->
    <script src="{{URL::asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{URL::asset('dist/js/app.min.js')}}"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{URL::asset('bootstrap/js/bootstrap-multiselect.js')}}"></script>
    <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>

    <script>
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


    </script>
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. Slimscroll is required when using the
         fixed layout. -->
  </body>
  </body>
</html>

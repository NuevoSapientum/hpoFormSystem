<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css"
    rel="stylesheet">
    <style type="text/css">
      .container{
        margin-top: 15px;
      }

    .btn-reg{
            width: 140px;
            height: 35px;
            font-family: Segoe UI, sans-serif;
            color: white;
            border-style: none;
            background-color: #308dd4;
        }

      .btn-flat{
        background-color: #308dd4;
        color: white;
        font-size: 13px;
        padding: 10px 60px 10px 50px;
      }

      .btn-flat:hover{
        text-decoration: none;
        color: white;
      }
    </style>
    </head>
    <body>
      
      <div class="container">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
        There were some problems creating an account:
        <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        </ul>
        </div>
        @endif
        <span class="label label-warning">Reminder: Only Admin can add user.</span>
          <h1>Create an Account</h1>
          <form action="{{ URL::to('/auth/register') }}" method="post">
            <div class="alert alert-info" role="alert">Info: The ID Number is the username.</div>
            
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <label>ID Number:</label>
            <input type="number" name="username" placeholder="Enter ID Number" class="form-control" value="{{old('username')}}" />
            <br/>
            <label>Full Name:</label>
            <input type="text" name="name" placeholder="Enter Full Name" class="form-control" value="{{old('name')}}" />
            <br/>
            <label>Gender:</label>
            <select class="form-control" id="gender" name="gender">
                <option value="Male" selected="true">Male</option>
                <option value="Female">Female</option>
            </select>
            <br/>
            <label>Position:</label>
            <select class="form-control" name="position">
              @foreach($positions_all as $positions)
                <option value="{{$positions->id}}">{{$positions->position_name}}</option>
              @endforeach
            </select>
            <label>Work Shift:</label>
            <select class="form-control" name="shift">
                @foreach($shifts as $shift)
                    <option value="{{$shift->id}}">{{date('h:i A', strtotime($shift->shift_from))}} to {{date('h:i A', strtotime($shift->shift_to))}}</option>
                @endforeach
            </select>
            <br/>
            <label>Email:</label>
            <input type="email" name="email" placeholder="hpo@example.com" class="form-control" value="{{old('email')}}" />
            <br/>
            <label>Vacation Leave Entitlement:</label>
            <input type="number" name="vacation_leave" value="0" class="form-control" />
            <br/>
            <label>Sick Leave Entitlement:</label>
            <input type="number" name="sick_leave" value="0" class="form-control" />
            <br/>
            <div id="ML" style="display:none">
                <label>Maternity Leave Entitlement:</label>
                <input type="number" name="maternity_leave" value="0" class="form-control" />
                <br/>
            </div>
            
            <div id="PL" style="display:none">
                <label>Paternity Leave Entitlement:</label>
                <input type="number" name="paternity_leave" value="0" class="form-control" />
                <br/>
            </div>
            <button class="btn-reg">Submit</button>
            <a href="{{URL::to('/dashboard')}}" class="btn-flat">Back</a>
          </form>
          <hr/>
          <!-- Main Footer -->
      <footer class="main-footer">
        <strong>Copyright &copy; 2015 <a href="http://www.hpoutsourcinginc.com/">HP Outsourcing Inc.</a></strong> All rights reserved.
      </footer>
      </div>
      <script src="{{URL::asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
      <script type="text/javascript">
      if($('#gender').val() == "Male"){
        $('#PL').css('display', 'block');
      }else if($('#gender').val() == "Female"){
        $('#ML').css('display', 'block');
      }

      $('#gender').change(function(){
        var gender = $('#gender').find(":selected").text();
        if(gender == "Male"){
            $('#ML').css('display', 'none');
            $('#PL').css('display', 'block');
            // alert(gender);
        }else if(gender == "Female"){
            $('#PL').css('display', 'none');
            $('#ML').css('display', 'block');
        }
      });
      </script>
    </body>   
</html>
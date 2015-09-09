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
        <span class="label label-warning">Reminder: Only Admin can add a user.</span>
          <h1>Create an Account</h1>
          <form action="{{ URL::to('/auth/register') }}" method="post">
            <div class="alert alert-danger" role="alert">Required: Their ID Number is their username.</div>
            
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <label>ID Number:</label>
            <input type="text" name="username" placeholder="Enter ID Number" class="form-control" value="{{old('username')}}" />
            <br/>
            <label>Full Name:</label>
            <input type="text" name="name" placeholder="Enter Full Name" class="form-control" value="{{old('name')}}" />
            <br/>
            <label>Position:</label>
            <select class="form-control" name="position" value="{{old('position')}}">
              <option value="Administrator">Administrator</option>
              <option value="QA Expert">QA Expert</option>
              <option value="Web Developer">Web Developer</option>
            </select>
            <br/>
            <label>Email:</label>
            <input type="email" name="email" placeholder="hpo@example.com" class="form-control" value="{{old('email')}}" />
            <br/>
            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter Password" class="form-control" value="{{old('password')}}" />
            <br/>
            <label>Confirm Password:</label>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" />
            <br/>
            <button class="btn-reg">Submit</button>
            <button class="btn-reg" onClick="goBack()">Back</button>
          </form>
          <hr/>
          <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2015 <a href="http://www.hpoutsourcinginc.com/">HP Outsourcing Inc.</a></strong> All rights reserved.
      </footer>
      </div>
      <script>
        function goBack() {
            window.history.back();
        }
      </script>
    </body>   
</html>
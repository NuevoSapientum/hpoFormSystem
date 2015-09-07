<!DOCTYPE html>
<html>
<head>
    <title>HP Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css"
    rel="stylesheet">

    <style type="text/css">
        body{
            background-image: url(img/bg.jpg);
        }

        .form-group{
            position: absolute;
            top: 50%;
            left:50%;
            transform: translate(-50%,-50%);
        }

        .form-control{
            width: 250px;
            border-radius: 0px;
        }
        .btn-login{
            width: 140px;
            height: 35px;
            font-family: Segoe UI, sans-serif;
            color: white;
            border-style: none;
            background-color: #308dd4;
        }

        .img-logo{
            width: 200px;
        }

        .logo{
            position: absolute;
            left: 05%;
        }
    </style>
</head>
<body>
    <div class="container"><!-- 
        <div class="logo">
            <img src='img/hpologo.png' class="img-logo">
        </div> -->
        <form action="/HP/public/auth/login" method="POST">
             @if (count($errors) > 0)
             <div class="alert alert-danger">
             <strong>Whoops! </strong> There were some problems with your input. <br> <br>
             <ul>
            
                    @foreach ($errors->all() as $error)
                 <li>{{ $error }} </li>
                @endforeach
             </ul>
             </div>
             @endif
            <div class="form-group">
                <img src="img/user.png" class="img-responsive" style="width: 140px; margin-left: 50px;">
                <hr/>
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <input type="text" class="form-control" name="username" placeholder="ID Number"  value="{{old('username')}}" autofocus/><br/>
                <input type="password" class="form-control" name="password" placeholder="Password" value="{{old('password')}}"/><hr/>
                <button type="submit" class="btn-login">Submit</button>
            </div>
        </form>
    </div>

</body>
</html>
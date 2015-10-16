<!DOCTYPE html>
<html>
<head>
    <title>HP Login</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
    <style type="text/css">
        body{
            background-image: url(img/bg.jpg);
        }

        form{
            position: absolute;
            top: 50%;
            left:50%;
            transform: translate(-50%,-50%);
        }

        .form-control{
            width: 300px;
            height: 40px;
            border-radius: 0px;
        }

        .btn-login{
            width: 140px;
            height: 35px;
            background-color: #308dd4;
            color: white;
            font-size: 16px;
            font-family: Segoe UI, sans-serif;
            border-radius: 0px;
            border-style: none;
            box-shadow: none;
        }

        .hpLogo{
            width: 200px;
            height: 150px;
            margin-left: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <br/>
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
        <form action="{{URL::to('/auth/login')}}" method="POST">
             
             <img src="img/logo.png" class="hpLogo">
                <div class="form-group">
                <hr/>
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <input type="number" class="form-control" name="username" placeholder="ID Number"  value="{{old('username')}}" autofocus/><br/>
                <input type="password" class="form-control" name="password" placeholder="Password" value="{{old('password')}}"/><hr/>
                <button type="submit" class="btn-login">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
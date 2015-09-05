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

        .img-user{
            width: 140px;
            margin-left: 50px;
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
    <div class="container">
        <div class="logo">
            <img src='img/hpologo.png' class="img-logo">
        </div>
        <form action="{{URL::to('/auth')}}">
            <div class="form-group">
                <img src="img/user.png" class="img-user">
                <hr/>
                <input type="text" class="form-control" name="User_ID" placeholder="ID Number" autofocus required/><br/>
                <input type="password" class="form-control" name="User_Password" placeholder="Password" required/><hr/>
                <button type="submit" class="btn-login">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
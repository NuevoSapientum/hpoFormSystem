<!DOCTYPE html>
<html>
<head>
    <title>HP Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css"
    rel="stylesheet">
    <script type="text/javascript" src="{{URL::asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('plugins/craftpip/jquery-confirm.min.css')}}">
    <script src="{{URL::asset('plugins/craftpip/jquery-confirm.min.js')}}"></script>

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
            width: 250px;
            height: 35px;
            font-family: Segoe UI, sans-serif;
            font-size: 15px;
            font-weight: 500;
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
        <form action="{{URL::to('/auth/login')}}" method="POST">
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
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                
                <input type="number" class="form-control" name="username" placeholder="ID Number"  value="{{old('username')}}" autofocus/><br/>
                <input type="password" class="form-control" name="password" placeholder="Password" value="{{old('password')}}"/><hr/>
                <button type="submit" class="btn-login">Submit</button>
            </div>
        </form>
        <!-- <button class="example-p-2">Try me</button> -->
    </div>
    <script type="text/javascript">
        // $('.example-p-2').on('click', function () {
        //                         $.confirm({
        //                             title: 'A critical action',
        //                             content: 'You can queue confirms, you\'ll be asked again for a confirmation.',
        //                             confirmButton: 'Proceed',
        //                             confirmButtonClass: 'btn-info',
        //                             icon: 'fa fa-question-circle',
        //                             animation: 'scale',
        //                             confirm: function () {
        //                                 $.confirm({
        //                                     title: 'A very critical action',
        //                                     content: 'Are you sure you want to proceed?',
        //                                     confirmButton: 'Hell, yes!',
        //                                     icon: 'fa fa-warning',
        //                                     confirmButtonClass: 'btn-warning',
        //                                     animation: 'zoom',
        //                                     confirm: function () {
        //                                         alert('A very critical action triggered!');
        //                                     }
        //                                 });
        //                             }
        //                         });
        //                     });
    </script>
</body>
</html>
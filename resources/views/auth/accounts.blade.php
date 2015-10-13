@extends('layout.default')

@section('head')
  @if(session('status') == "Success!")
    <div class="alert alert-success">
      <h4>{{session('status')}}</h4>
    </div>
  @elseif(session('status') == "Failed!")
    <div class="alert alert-warning">
      <h4>{{session('status')}}</h4>
    </div>
  @elseif(session('status') == "Nothing to Show.")
    <div class="alert alert-danger">
        <h4>{{session('status')}}</h4>
    </div>
  @endif
  <div class="well well-sm">
    <h1>
      Manage Employee Accounts
    </h1>  
  </div>
@endsection

@section('content')
  <table id="example">
    <thead>
      <tr>
        <th>ID Number</th>
        <th>Name</th>
        <th>Position</th>
        <th>Email</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
        <tr>
        <td>{{$user->username}}</td>
        <td>{{$user->emp_name}}</td>
        <td>{{$user->position_name}}</td>
        <td>{{$user->email}}</td>
        <td>
          <a href="{{URL::to('accounts/show/' . $user->id)}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>&nbsp;|&nbsp;
          <a href="{{URL::to('accounts/resetPassword/' . $user->id)}}"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Reset Password</a>
        </td>
        </tr>
    @endforeach
    </tbody>
  </table>
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
  <script>
  $(function(){
    $("#example").dataTable();
  })
  </script>
@endsection
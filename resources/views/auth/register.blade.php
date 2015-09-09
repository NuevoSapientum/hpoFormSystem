@extends('layout.default')

      @section('head')
          <span class="label label-warning">Reminder: Only Admin can add a user.</span>
      @endsection

      @section('content')
          <h1>Create an Account</h1>
          <form action="{{ URL::to('/auth/register') }}" method="post">
            <div class="alert alert-danger" role="alert">Required: Their ID Number is their username.</div>
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
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
          	<label>ID Number:</label>
          	<input type="text" name="username" placeholder="Enter ID Number" class="form-control" />
          	<br/>
          	<label>Full Name:</label>
          	<input type="text" name="name" placeholder="Enter Full Name" class="form-control" />
          	<br/>
            <label>Position:</label>
            <select class="form-control" name="position">
              <option value="Administrator">Administrator</option>
              <option value="QA Expert">QA Expert</option>
              <option value="Web Developer">Web Developer</option>
            </select>
            <br/>
            <label>Email:</label>
            <input type="email" name="email" placeholder="hpo@example.com" class="form-control" />
            <br/>
          	<label>Password:</label>
          	<input type="password" name="password" placeholder="Enter Password" class="form-control" />
          	<br/>
          	<label>Confirm Password:</label>
          	<input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" />
          	<br/>
          	<button class="btn btn-primary">Submit</button>
          </form>
      @endsection


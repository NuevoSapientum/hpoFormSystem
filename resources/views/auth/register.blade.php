@extends('layout.default')

      @section('head')
          <span class="label label-warning">Reminder: Only Admin can add a user.</span>
      @endsection

      @section('content')
          <h1>Create an Account</h1>
          <form>
          	<label>ID Number:</label>
          	<input type="text" placeholder="Enter ID Number" class="form-control" />
          	<br/>
          	<label>Full Name:</label>
          	<input type="text" placeholder="Enter Full Name" class="form-control" />
          	<br/>
          	<label>Password:</label>
          	<input type="password" placeholder="Enter Password" class="form-control" />
          	<br/>
          	<label>Confirm Password:</label>
          	<input type="password" placeholder="Confirm Password" class="form-control" />
          	<br/>
          	<button class="btn btn-primary">Submit</button>
          </form>
      @endsection


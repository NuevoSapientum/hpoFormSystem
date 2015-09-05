@extends('layout.default')

@section('head')
  <h1>
    Request for Leave of Absence
  </h1>
@endsection

@section('content')
    <form>
      <label>Date:</label>
      <input type="date" disabled class="form-control" value="<?php echo date('Y-m-d');?>"/>
      <br/>
      <label>Type of Leave:</label>
      <br/>
      <input type="radio" name="typeofLeave" checked="checked" value="Vacation" />Vacation Leave  &nbsp;&nbsp;&nbsp;&nbsp;
      <input type="radio" name="typeofLeave" value="Sick" />Sick Leave &nbsp;&nbsp;&nbsp;&nbsp;
      <input type="radio" name="typeofLeave" value="Maternity" />Maternity Leave &nbsp;&nbsp;&nbsp; 
      <input type="radio" name="typeofLeave" value="Paternity" />Paternity Leave <br/>
      <br/>
      <label>Reason(s) for Absence:</label>
      <textarea class="form-control"></textarea>
      <br/>
      <label>Recommending Approval:</label>
      <select class="form-control">
          <option value="Jay Timbal">Jay Timbal</option>
          <option value="Solis Roltaire">Solis Roltaire</option>
          <option value="Jerrymae Noya">Jerrymae Noya</option>
      </select>
      <br/>
      <label>Approved by:</label>
      <select class="form-control">
          <option value="Rodrigo Duterte">Rodrigo Duterte</option>
          <option value="Erwin Mark Añora">Erwin Mark Añora</option>
          <option value="Will Smith">Will Smith</option>
      </select><br/>
      <table>
        <!-- Inclusive Dates of Leave -->
      </table>
      <label>Entitlement:</label> 
      <input type="text" class="form-control"/><br/>
      <label>Days Already Taken:</label> 
      <input type="text" class="form-control" disabled value="3 Days"/><br/>
      <label>Days Applied For:</label> 
      <br/>
      <select class="form-control">
        <option value="1">1 Day</option>
        <option value="2">2 Days</option>
      </select><br/>
      <label>Balance:</label> 
      <input type="text" class="form-control" disabled value="2 Days"/><br/>
      <button type="submit" class="btn btn-primary">Submit</button>
  </form>
@endsection
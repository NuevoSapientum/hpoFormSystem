@extends('layout.default')

@section('head')
  <h1>
    Overtime Authorization Slip
  </h1>
@endsection

@section('content')
  <form>
      <label>Date:</label>
      <input type="date" disabled class="form-control" value="<?php echo date('Y-m-d');?>"/>
      <br/>
      <label>Name:</label>
      <br/>
      <input type="text" class="form-control"/>
      <br/>
      <label>Department:</label>
      <select class="form-control">
          <option value="Human Resource">Human Resource</option>
          <option value="System Engine Optimization">System Engine Optimization</option>
          <option value="Quality Assurance">Quality Assurance</option>
      </select>
      <br/>
      <label>Client:</label>
      <br/>
      <input type="text" class="form-control"/>
      <br/>
      <label>Detailed Purpose of Overtime:</label>
      <textarea class="form-control"></textarea>

      <br/>
      <button type="submit" class="btn btn-primary">Submit</button>
  </form>
@endsection
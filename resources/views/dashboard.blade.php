@extends('layout.default')

      @section('head')
        @if(session('status') == "Success!" && session('status') != "")
          <div class="alert alert-success">
            <h4>{{session('status')}}</h4>
          </div>
        @elseif(session('status') != "")
          <div class="alert alert-warning">
            <h4>{{session('status')}}</h4>
          </div>
        @endif
        
        <div class="well well-sm">
        <h1>
          HP Outsourcing E-request System
        </h1>  
      </div>
      @endsection

      @section('content')
          <p style="font-size: 15px" class="text-justify">
            It is an E-request form system that will provide online form submission and validation that the 
            employee will use in filing there exit pass, request for leave of absence, overtime authorization and 
            change schedule. 
          </p>
          <br/>
          <label>Types of Forms:</label>
          <hr/>
          <pre>
              <strong>Exit pass</strong>
          -form template if you want to go outside the company for a period of time during working hours.
              <br/>
              <strong> Request for Leave of Absence</strong>
          -form template if you want to apply for a leave of absence (eg. Sick Leave, Vacation Leave, Maternal Leave, Paternal Leave )
              <br/>
              <strong>Overtime Authorization</strong>
          -form template if you want to apply for an overtime.
              <br/>
              <strong>Change schedule</strong>
          -form template if you want to change your schedule.
          </pre>
      @endsection


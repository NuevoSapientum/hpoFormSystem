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
          Home Page
        </h1>  
      </div>
      @endsection

      @section('content')

      @endsection


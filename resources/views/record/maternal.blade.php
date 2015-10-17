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
      @endsection

      @section('content')
          <h1>Maternal Leave Records</h1>
          <hr/>
          <table>
          <table id="example">
          <thead>
            <tr>
              <th>Name</th>
              <th>Date Created</th>
              <th>Date Approved</th>
              <th>Days Applied</th>
              <th>Last Leave</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($maternalRecords as $maternal)
              <tr>
                <td>{{$maternal->users->emp_name}}</td>
                <td>{{date('F d, Y', strtotime($maternal->created_at))}}</td>
                <td>{{date('F d, Y', strtotime($maternal->updated_at))}}</td>
                <td>{{$maternal->days_applied}}</td>
                <td>{{date('F d, Y', strtotime($maternal->start_date))}}</td>
                @if($maternal->status === 1)
                  <td>Approved</td>
                @endif
                <td>
                  <a href="{{URL::to('record/maternal/view/' . $maternal->leave_type . '/' . $maternal->id)}}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>
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


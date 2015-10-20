@extends('layout.default')

      @section('head')

      @endsection

      @section('content')
          <h1>Vacation Leave Records</h1>
          <hr/>
          <table>
          <table id="example">
          <thead>
            <tr>
              <th>Name</th>
              <th>Entitlement</th>
              <th>Balance</th>
              <th>Last Leave</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              @foreach($vacationRecords as $vacation)
              <tr>
                <td>{{$user->emp_name}}</td>
                <td>{{$user->VL_entitlement}}</td>
                <td>{{max($balance[$i++],0)}}</td>
                @if($vacation->user_id == $user->id)
                <td>{{date('F d, Y', strtotime($vacation->start_date))}}</td>
                <td>
                  <a href="{{URL::to('record/vacation/view/' . $vacation->users->id)}}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> View User Records</a>
                </td>
                @else
                <td>N/A</td>
                <td>
                  <a href="{{URL::to('record/vacation/view/' . $user->id)}}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> View User Records</a>
                </td>
                @endif
              </tr> 
              @endforeach
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


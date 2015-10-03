@extends('layout.default')

@section('head')
  <h1>
    Welcome {{Auth::user()->emp_name}}
  </h1>
@endsection

@section('content')
  <h1>Inbox</h1>
  <table>
    <table id="example">
    <thead>
      <tr>
        <th>Form</th>
        <th>Date Created</th>
        <th>Status</th>
        <th>Date Updated</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($exitPass as $exit)
        <tr>
        <td>Exit Pass</td>
        <td>{{$exit->dateCreated}}</td>
        @if($exit->status == 1)
          <td>Active</td>
        @elseif($exit->status == 2)
          <td>Approved</td>
        @else
          <td>Closed</td>
        @endif
        <td>{{$exit->dateUpdated}}</td>
        <td>
          <a href="{{URL::to('')}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>&nbsp;|&nbsp;
          <a href="{{URL::to('')}}"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Delete</a>
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
  </table>
@endsection
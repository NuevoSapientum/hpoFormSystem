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
      Welcome {{Auth::user()->emp_name}}
    </h1>  
  </div>
@endsection

@section('content')
  <table>
    <table id="example">
    <thead>
      <tr>
        <th>Employee</th>
        <th>Date Created</th>
        <th>Date Updated</th>
        <th>Form</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($exitApprovals as $exit)
        <tr>
          <td>{{$exit->emp_name}}</td>
          <td>{{$exit->dateCreated}}</td>
          <td>{{$exit->dateUpdated}}</td>
          <td>Exit Pass</td>
          <td>
            <a href="{{URL::to('approval/view/' . $exit->form_type . '/' . $exit->tbl_epid)}}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>
          </td>
        </tr>
      @endforeach
      @foreach($leaveApprovals as $leave)
        <tr>
          <td>{{$leave->emp_name}}</td>
          <td>{{$leave->date_created}}</td>
          <td>{{$leave->dateUpdated}}</td>
          <td>Request for Leave of Absence</td>
          <td>
            <a href="{{URL::to('approval/view/' . $leave->form_type . '/' . $leave->tbl_leaveid)}}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>
          </td>
        </tr>
      @endforeach
      @foreach($changeApprovals as $change)
        <tr>
          <td>{{$change->emp_name}}</td>
          <td>{{$change->date_created}}</td>
          <td>{{$change->dateUpdated}}</td>
          <td>Change of Schedule</td>
          <td>
            <a href="{{URL::to('approval/view/' . $change->form_type . '/' . $change->chgschd_id)}}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>
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
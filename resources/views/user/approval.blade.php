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
        <th>Status</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($exitApprovals as $exit)
      <tr>
        <td>{{$exit->users->emp_name}}</td>
        <td>{{date('F d, Y', strtotime($exit->created_at))}}</td>
        <td>{{date('F d, Y', strtotime($exit->updated_at))}}</td>
        <td>Exit Pass</td>
        @if($exit->status === 0)
          <td>Pending</td>
        @elseif($exit->status === 1)
          <td>Approved</td>
        @elseif($exit->status === 2)
          <td>Denied</td>
        @endif
        <td>
            <a href="{{URL::to('approval/view/' . $exit->form_id . '/' . $exit->id)}}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>
        </td>
      </tr>
      @endforeach

      @foreach($leaveApprovals as $leave)
        <tr>
          <td>{{$leave->users->emp_name}}</td>
          <td>{{date('F d, Y', strtotime($leave->created_at))}}</td>
          <td>{{date('F d, Y', strtotime($leave->updated_at))}}</td>
          <td>Request for Leave of Absence</td>
          @if($leave->status === 0)
            <td>Pending</td>
          @elseif($leave->status === 1)
            <td>Approved</td>
          @elseif($leave->status === 2)
            <td>Denied</td>
          @endif
          <td>
            <a href="{{URL::to('approval/view/' . $leave->form_id . '/' . $leave->id)}}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>
          </td>
        </tr>
      @endforeach

      @foreach($changeApprovals as $change)
        <tr>
          <td>{{$change->users->emp_name}}</td>
          <td>{{date('F d, Y', strtotime($change->created_at))}}</td>
          <td>{{date('F d, Y', strtotime($change->updated_at))}}</td>
          <td>Change of Schedule</td>
          @if($change->status === 0)
            <td>Pending</td>
          @elseif($change->status === 1)
            <td>Approved</td>
          @elseif($change->status === 2)
            <td>Denied</td>
          @endif
          <td>
            <a href="{{URL::to('approval/view/' . $change->form_id . '/' . $change->id)}}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>
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
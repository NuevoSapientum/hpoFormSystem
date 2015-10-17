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
  @elseif(session('status') == "You don't have any days of leave left.")
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
        <th>Date Created</th>
        <th>Date Updated</th>
        <th>Form</th>
        <th>Status</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($exitPass as $exit)
        @if($exit->status == 3)
        @else
        <tr>
        
        <td>{{date('F d, Y', strtotime($exit->created_at))}}</td>
        <td>{{date('F d, Y', strtotime($exit->updated_at))}}</td>
        <td>Exit Pass</td>
        @if($exit->status == 0)
          <td>Pending</td>
          <td>
            <a href="{{URL::to('inbox/edit/' . $exit->form_id . '/' .$exit->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>&nbsp;|&nbsp;
            <a href="{{URL::to('inbox/delete/' . $exit->form_id . '/' . $exit->id  )}}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
          </td>
        @elseif($exit->status == 1)
          <td>Approved</td>
          <td>
            <a href="{{URL::to('inbox/edit/' . $exit->form_id . '/' .$exit->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
          </td>
        @elseif($exit->status == 2)
          <td>Denied</td>
          <td><a href="{{URL::to('inbox/edit/' . $exit->form_id . '/' .$exit->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a></td>
        @endif
        </tr>
        @endif
      @endforeach
      @foreach($leaveForm as $leave)
        @if($leave->status == 3)
        @else
        <tr>
        <td>{{date('F d, Y', strtotime($leave->created_at))}}</td>
        <td>{{date('F d, Y', strtotime($leave->updated_at))}}</td>
        <td>Request for Leave of Absence</td>
        @if($leave->status == 0)
          <td>Pending</td>
          <td>
            <a href="{{URL::to('inbox/edit/' . $leave->form_id . '/' . $leave->id)}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>&nbsp;|&nbsp;
            <a href="{{URL::to('inbox/delete/' . $leave->form_id . '/' . $leave->id )}}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
          </td>
        @elseif($leave->status == 1)
          <td>Approved</td>
          <td>
            <a href="{{URL::to('inbox/edit/' . $leave->form_id . '/' . $leave->id)}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
          </td>
        @elseif($leave->status == 2)
          <td>Denied</td>
          <td><a href="{{URL::to('inbox/edit/' . $leave->form_id . '/' .$leave->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a></td>
        @endif
        </tr>
        @endif
      @endforeach
      @foreach($changeSchedule as $change)
        @if($change->status == 3)
        @else
        <tr>
        <td>{{date('F d, Y', strtotime($change->created_at))}}</td>
        <td>{{date('F d, Y', strtotime($change->updated_at))}}</td>
        <td>Change Schedule</td>
        @if($change->status == 0)
          <td>Pending</td>
          <td>
            <a href="{{URL::to('inbox/edit/' . $change->form_id . '/' . $change->id)}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>&nbsp;|&nbsp;
            <a href="{{URL::to('inbox/delete/' . $change->form_id . '/' . $change->id)}}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
          </td>
        @elseif($change->status == 1)
          <td>Approved</td>
          <td>
            <a href="{{URL::to('inbox/edit/' . $change->form_id . '/' . $change->id)}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
          </td>
        @elseif($change->status == 2)
          <td>Denied</td>
          <td><a href="{{URL::to('inbox/edit/' . $change->form_id . '/' .$change->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a></td>
        
        @endif
        </tr>
        @endif
      @endforeach
      @foreach($oas as $over)
        @if($over->status == 3)
        @else
        <tr>
        <td>{{date('F d, Y', strtotime($over->created_at))}}</td>
        <td>{{date('F d, Y', strtotime($over->updated_at))}}</td>
        <td>Overtime Authorization Slip</td>
        @if($over->status == 0)
          <td>Pending</td>
          <td>
            <a href="{{URL::to('inbox/edit/' . $over->form_id . '/' . $over->id)}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>&nbsp;|&nbsp;
            <a href="{{URL::to('inbox/delete/' . $over->form_id . '/' . $over->id)}}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
          </td>
        @elseif($over->status == 1)
          <td>Approved</td>
          <td>
            <a href="{{URL::to('inbox/edit/' . $over->form_id . '/' . $over->id)}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
          </td>
        @elseif($over->status == 2)
          <td>Denied</td>
          <td><a href="{{URL::to('inbox/edit/' . $over->form_id . '/' .$over->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a></td>
        @endif
        </tr>
        @endif
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
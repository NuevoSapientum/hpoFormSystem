@extends('layout.default')
  @section('head') 
    <div class="well well-sm">
    <h1>
      History
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
      <tr>
        <td>{{$exit->dateCreated}}</td>
        <td>{{$exit->dateUpdated}}</td>
        <td>Exit Pass</td>
        @if($exit->status == 0)
        <td>Pending</td>
        <td>
          <a href="{{URL::to('inbox/edit/' . $exit->form_type . '/' .$exit->tbl_epid )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>&nbsp;|&nbsp;
          <a href="{{URL::to('inbox/delete/' . $exit->form_type . '/' . $exit->tbl_epid  )}}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
        </td>
        @elseif($exit->status == 1)
        <td>Approved</td>
        <td>
          <a href="{{URL::to('inbox/edit/' . $exit->form_type . '/' .$exit->tbl_epid )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
        </td>
        @elseif($exit->status == 2)
        <td>Denied</td>
        <td>
          <a href="{{URL::to('inbox/edit/' . $exit->form_type . '/' .$exit->tbl_epid )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
        </td>
        @endif
      </tr>
      @endforeach

      @foreach($leaveForm as $leave)
      <tr>
        <td>{{$leave->date_created}}</td>
        <td>{{$leave->dateUpdated}}</td>
        <td>Request for Leave of Absence</td>
        @if($leave->status == 0)
        <td>Pending</td>
        <td>
          <a href="{{URL::to('inbox/edit/' . $leave->form_type . '/' .$leave->tbl_leaveid )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>&nbsp;|&nbsp;
          <a href="{{URL::to('inbox/delete/' . $leave->form_type . '/' . $leave->tbl_leaveid  )}}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
        </td>
        @elseif($leave->status == 1)
        <td>Approved</td>
        <td>
          <a href="{{URL::to('inbox/edit/' . $leave->form_type . '/' .$leave->tbl_leaveid )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
        </td>
        @elseif($leave->status == 2)
        <td>Denied</td>
        <td>
          <a href="{{URL::to('inbox/edit/' . $leave->form_type . '/' .$leave->tbl_leaveid )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
        </td>
        @endif
      </tr>
      @endforeach

      @foreach($changeSchedule as $change)
      <tr>
        <td>{{$change->date_created}}</td>
        <td>{{$change->dateUpdated}}</td>
        <td>Change Schedule</td>
        @if($change->status == 0)
        <td>Pending</td>
        <td>
          <a href="{{URL::to('inbox/edit/' . $change->form_type . '/' .$change->chgschd_id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>&nbsp;|&nbsp;
          <a href="{{URL::to('inbox/delete/' . $change->form_type . '/' . $change->chgschd_id  )}}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
        </td>
        @elseif($change->status == 1)
        <td>Approved</td>
        <td>
          <a href="{{URL::to('inbox/edit/' . $change->form_type . '/' .$change->chgschd_id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
        </td>
        @elseif($change->status == 2)
        <td>Denied</td>
        <td>
          <a href="{{URL::to('inbox/edit/' . $change->form_type . '/' .$change->chgschd_id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
        </td>
        @endif
      </tr>
      @endforeach
        
      @foreach($oas as $over)
      @if($over->status != 3)
      <td>{{$over->date_created}}</td>
        <td>{{$over->dateUpdated}}</td>
        <td>Overtime Authorization</td>
        @if($over->status == 0)
        <td>Pending</td>
        <td>
          <a href="{{URL::to('inbox/edit/' . $over->form_type . '/' .$over->tbl_oasid )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>&nbsp;|&nbsp;
          <a href="{{URL::to('inbox/delete/' . $over->form_type . '/' . $over->tbl_oasid  )}}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
        </td>
        @elseif($over->status == 1)
        <td>Approved</td>
        <td>
          <a href="{{URL::to('inbox/edit/' . $over->form_type . '/' .$over->tbl_oasid )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
        </td>
        @elseif($over->status == 2)
        <td>Denied</td>
        <td>
          <a href="{{URL::to('inbox/edit/' . $over->form_type . '/' .$over->tbl_oasid )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
        </td>
        @endif
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
  @endsection
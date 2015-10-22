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
          <h1>Employees Submitted Forms</h1>
          <hr/>
            <a class="btn btn-primary" href="{{URL::to('/submittedforms')}}" style="width:170px">All Forms</a>
            <a class="btn btn-primary" href="{{URL::to('/submittedforms/exit')}}" style="width:170px">Exit Pass</a>
            <a class="btn btn-primary" href="{{URL::to('/submittedforms/leave')}}" style="width:250px">Request for Leave of Absence</a>
            <a class="btn btn-primary" href="{{URL::to('/submittedforms/change')}}" style="width:170px">Change Schedule</a>
            <a class="btn btn-primary" href="{{URL::to('/submittedforms/overtime')}}" style="width:250px">Overtime Authorization</a>
          <hr/>
          <table id="example">
          <thead>
            <tr>
              <th>Name</th>
              <th>Date Created</th>
              <th>Date Updated</th>
              <th>Form</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($exitPass as $exit)
            <tr id="exitPass">
              <td>{{$exit->users->emp_name}}</td>
              <td>{{date('F d, Y', strtotime($exit->created_at))}}</td>
              <td>{{date('F d, Y', strtotime($exit->updated_at))}}</td>
              <td>Exit Pass</td>
              @if($exit->status == 0)
              <td>Pending</td>
              <td>
                <a href="{{URL::to('submittedforms/edit/' . $exit->form_id . '/' .$exit->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>&nbsp;|&nbsp;
                <a href="{{URL::to('submittedforms/delete/' . $exit->form_id . '/' . $exit->id  )}}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
              </td>
              @elseif($exit->status == 1)
              <td>Approved</td>
              <td>
                <a href="{{URL::to('submittedforms/edit/' . $exit->form_id . '/' .$exit->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
              </td>
              @elseif($exit->status == 2)
              <td>Denied</td>
              <td>
                <a href="{{URL::to('submittedforms/view/' . $exit->form_id . '/' .$exit->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
              </td>
              @elseif($exit->status == 3)
              <td>Closed</td>
              <td>
                <a href="{{URL::to('submittedforms/view/' . $exit->form_id . '/' .$exit->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
              </td>
              @endif
            </tr>
            @endforeach

            @foreach($leaveForm as $leave)
            <tr id="leaveForm">
              <td>{{$leave->users->emp_name}}</td>
              <td>{{date('F d, Y', strtotime($leave->created_at))}}</td>
              <td>{{date('F d, Y', strtotime($leave->updated_at))}}</td>
              <td>Request for Leave of Absence</td>
              @if($leave->status == 0)
              <td>Pending</td>
              <td>
                <a href="{{URL::to('submittedforms/edit/' . $leave->form_id . '/' .$leave->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>&nbsp;|&nbsp;
                <a href="{{URL::to('submittedforms/delete/' . $leave->form_id . '/' . $leave->id  )}}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
              </td>
              @elseif($leave->status == 1)
              <td>Approved</td>
              <td>
                <a href="{{URL::to('submittedforms/edit/' . $leave->form_id . '/' .$leave->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
              </td>
              @elseif($leave->status == 2)
              <td>Denied</td>
              <td>
                <a href="{{URL::to('submittedforms/view/' . $leave->form_id . '/' .$leave->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
              </td>
              @elseif($leave->status == 3)
              <td>Closed</td>
              <td>
                <a href="{{URL::to('submittedforms/view/' . $leave->form_id . '/' .$leave->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
              </td>
              @endif
            </tr>
            @endforeach

            @foreach($changeSchedule as $change)
            <tr id="changeSchedule">
              <td>{{$change->users->emp_name}}</td>
              <td>{{date('F d, Y', strtotime($change->created_at))}}</td>
              <td>{{date('F d, Y', strtotime($change->updated_at))}}</td>
              <td>Change Schedule</td>
              @if($change->status == 0)
              <td>Pending</td>
              <td>
                <a href="{{URL::to('submittedforms/edit/' . $change->form_id . '/' .$change->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>&nbsp;|&nbsp;
                <a href="{{URL::to('submittedforms/delete/' . $change->form_id . '/' . $change->id  )}}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
              </td>
              @elseif($change->status == 1)
              <td>Approved</td>
              <td>
                <a href="{{URL::to('submittedforms/edit/' . $change->form_id . '/' .$change->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
              </td>
              @elseif($change->status == 2)
              <td>Denied</td>
              <td>
                <a href="{{URL::to('submittedforms/view/' . $change->form_id . '/' .$change->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
              </td>
              @elseif($change->status == 3)
              <td>Closed</td>
              <td>
                <a href="{{URL::to('submittedforms/view/' . $change->form_id . '/' .$change->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
              </td>
              @endif
            </tr>
            @endforeach
              
            @foreach($oas as $over)
            <tr id="over">
              <td>{{$over->users->emp_name}}</td>
              <td>{{date('F d, Y', strtotime($over->created_at))}}</td>
              <td>{{date('F d, Y', strtotime($over->updated_at))}}</td>
              <td>Overtime Authorization</td>
              @if($over->status == 0)
              <td>Pending</td>
              <td>
                <a href="{{URL::to('submittedforms/edit/' . $over->form_id . '/' .$over->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>&nbsp;|&nbsp;
                <a href="{{URL::to('submittedforms/delete/' . $over->form_id . '/' . $over->id  )}}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
              </td>
              @elseif($over->status == 1)
              <td>Approved</td>
              <td>
                <a href="{{URL::to('submittedforms/edit/' . $over->form_id . '/' .$over->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
              </td>
              @elseif($over->status == 2)
              <td>Denied</td>
              <td>
                <a href="{{URL::to('submittedforms/view/' . $over->form_id . '/' .$over->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
              </td>
              @elseif($over->status == 3)
              <td>Closed</td>
              <td>
                <a href="{{URL::to('submittedforms/view/' . $over->form_id . '/' .$over->id )}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> View</a>
              </td>
              @endif
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


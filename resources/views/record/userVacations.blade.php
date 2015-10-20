@extends('layout.default')

@section('head')
	<h1>View {{$users->emp_name}} Vacation Leaves</h1>
@endsection

@section('content')
	<hr/>
	<label>Vacation Leave Entitlement: {{$VL_entitlement}}</label>
	<br/>
	<label>Balance: {{$balance}}</label>
	<br/>
	<br/>
	<table id="example">
          <thead>
            <tr>
              <th>Date Created</th>
              <th>Date Approved</th>
              <th>Days Applied</th>
              <th>Days Taken</th>
              <th>Start Leave</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          	@foreach($vacationRecords as $vacation)
              <tr>
                <td>{{date('F d, Y', strtotime($vacation->created_at))}}</td>
                <td>{{date('F d, Y', strtotime($vacation->updated_at))}}</td>
                <td>{{$vacation->days_applied}}</td>
                <td>{{$vacation->users->VL_taken}}</td>
                <td>{{date('F d, Y', strtotime($vacation->start_date))}}</td>
                @if($vacation->status === 0)
                  <td>Pending</td>
                @elseif($vacation->status === 1)
                  <td>Approved</td>
                @elseif($vacation->status === 2)
                  <td>Denied</td>
                @endif
                <td>
                  <a href="{{URL::to('record/vacation/view/' . $vacation->leave_type . '/' . $vacation->id)}}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>
               	</td>
              </tr> 
               @endforeach
          </tbody>
         
        </table>
        <script>
        $(function(){
          $("#example").dataTable();
        })
        </script>
@endsection


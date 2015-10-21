@extends('layout.default')

@section('head')
	<h1>View {{$users->emp_name}} Sick Leaves</h1>
@endsection

@section('content')
	<hr/>
	<label>Sick Leave Entitlement: {{$SL_entitlement}}</label>
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
          	@foreach($sickRecords as $sick)
              <tr>
                <td>{{date('F d, Y', strtotime($sick->created_at))}}</td>
                <td>{{date('F d, Y', strtotime($sick->updated_at))}}</td>
                <td>{{$sick->days_applied}}</td>
                <td>{{$sick->users->SL_taken}}</td>
                <td>{{date('F d, Y', strtotime($sick->start_date))}}</td>
                @if($sick->status === 0)
                  <td>Pending</td>
                @elseif($sick->status === 1)
                  <td>Approved</td>
                @elseif($sick->status === 2)
                  <td>Denied</td>
                @endif
                <td>
                  <a href="{{URL::to('record/sick/view/' . $sick->leave_type . '/' . $sick->id)}}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>
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


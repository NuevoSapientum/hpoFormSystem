@extends('layout.default')

@section('head')
	<h1>View {{$users->emp_name}} Paternity Leaves</h1>
@endsection

@section('content')
	<hr/>
	<label>Paternity Leave Entitlement: {{$PL_entitlement}}</label>
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
          	@foreach($paternityRecords as $paternity)
              <tr>
                <td>{{date('F d, Y', strtotime($paternity->created_at))}}</td>
                <td>{{date('F d, Y', strtotime($paternity->updated_at))}}</td>
                <td>{{$paternity->days_applied}}</td>
                <td>{{$paternity->users->PL_taken}}</td>
                <td>{{date('F d, Y', strtotime($paternity->start_date))}}</td>
                @if($paternity->status === 0)
                  <td>Pending</td>
                @elseif($paternity->status === 1)
                  <td>Approved</td>
                @elseif($paternity->status === 2)
                  <td>Denied</td>
                @endif
                <td>
                  <a href="{{URL::to('record/paternity/view/' . $paternity->leave_type . '/' . $paternity->id)}}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>
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


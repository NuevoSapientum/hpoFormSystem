@extends('layout.default')

@section('head')
	<h1>View {{$users->emp_name}} Paternal Leaves</h1>
@endsection

@section('content')
	<hr/>
	<label>Paternal Leave Entitlement: {{$PL_entitlement}}</label>
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
          	@foreach($paternalRecords as $paternal)
              <tr>
                <td>{{date('F d, Y', strtotime($paternal->created_at))}}</td>
                <td>{{date('F d, Y', strtotime($paternal->updated_at))}}</td>
                <td>{{$paternal->days_applied}}</td>
                <td>{{$paternal->users->PL_taken}}</td>
                <td>{{date('F d, Y', strtotime($paternal->start_date))}}</td>
                @if($paternal->status === 0)
                  <td>Pending</td>
                @elseif($paternal->status === 1)
                  <td>Approved</td>
                @elseif($paternal->status === 2)
                  <td>Denied</td>
                @endif
                <td>
                  <a href="{{URL::to('record/paternal/view/' . $paternal->leave_type . '/' . $paternal->id)}}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>
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


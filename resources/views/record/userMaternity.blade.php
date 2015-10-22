@extends('layout.default')

@section('head')
	<h1>View {{$users->emp_name}} Maternity Leaves</h1>
@endsection

@section('content')
	<hr/>
	<label>Maternity Leave Entitlement: {{$ML_entitlement}}</label>
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
          	@foreach($maternityRecords as $maternity)
              <tr>
                <td>{{date('F d, Y', strtotime($maternity->created_at))}}</td>
                <td>{{date('F d, Y', strtotime($maternity->updated_at))}}</td>
                <td>{{$maternity->days_applied}}</td>
                <td>{{$maternity->users->VL_taken}}</td>
                <td>{{date('F d, Y', strtotime($maternity->start_date))}}</td>
                @if($maternity->status === 0)
                  <td>Pending</td>
                @elseif($maternity->status === 1)
                  <td>Approved</td>
                @elseif($maternity->status === 2)
                  <td>Denied</td>
                @endif
                <td>
                  <a href="{{URL::to('record/maternity/view/' . $maternity->leave_type . '/' . $maternity->id)}}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>
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


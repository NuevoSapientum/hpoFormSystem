@extends('layout.default')

@section('head')
	<h1>View {{$users->emp_name}} Maternal Leaves</h1>
@endsection

@section('content')
	<hr/>
	<label>Maternal Leave Entitlement: {{$ML_entitlement}}</label>
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
          	@foreach($maternalRecords as $maternal)
              <tr>
                <td>{{date('F d, Y', strtotime($maternal->created_at))}}</td>
                <td>{{date('F d, Y', strtotime($maternal->updated_at))}}</td>
                <td>{{$maternal->days_applied}}</td>
                <td>{{$maternal->users->VL_taken}}</td>
                <td>{{date('F d, Y', strtotime($maternal->start_date))}}</td>
                @if($maternal->status === 0)
                  <td>Pending</td>
                @elseif($maternal->status === 1)
                  <td>Approved</td>
                @elseif($maternal->status === 2)
                  <td>Denied</td>
                @endif
                <td>
                  <a href="{{URL::to('record/maternal/view/' . $maternal->leave_type . '/' . $maternal->id)}}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>
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


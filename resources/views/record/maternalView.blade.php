@extends('layout.default')

@section('head')
	<h1>Maternal Leave</h1>
@endsection

@section('content')
    @foreach($contents as $content)
	<form method="POST" action="" enctype="multipart/form-data">
		<hr/>
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <label>Employee Name:</label>
    <input disabled value="{{$content->users->emp_name}}" class="form-control" />
    <br/>
    <label>Days Applied</label>
    @if($content->days_applied == 1)
	    <input type="text" class="form-control" disabled value="{{$content->days_applied}} Day" />
    @else
	    <input type="text" class="form-control" disabled value="{{$content->days_applied}} Days" />
    @endif
    <br/>
    <label>Start Date:</label>
    <input class="form-control" disabled value="{{date('F d, Y', strtotime($content->start_date))}}" />
    <hr/>

	  <label>Reason(s) for Absence:</label>
      <textarea class="form-control" disabled="true">{{$content->purpose}}</textarea>
      <br/>
      <label>Recommending Approval:</label>
      @foreach($permissioners as $permissioner)
        @if($permissioner->id === $content->permission_id1)
          <input type="text" class="form-control" disabled="true" value="{{$permissioner->emp_name}}"/>
        @endif
      @endforeach
      <div class="radio">
          @if($content->permission_1 === 1)
              <label><input type="radio" disabled checked="true"/>Yes</label>
              <label><input type="radio" disabled />No</label>
            @elseif($content->permission_1 === 2)
              <label><input type="radio" disabled />Yes</label>
              <label><input type="radio" disabled checked="true"/>No</label>
          @else
            <label><input type="radio" disabled />Yes</label>
                  <label><input type="radio" disabled />No</label>
          @endif
      </div>
      <br/>
      <label>Approved by:</label>
      @foreach($permissioners as $permissioner)
        @if($permissioner->id === $content->permission_id2)
          <input type="text" class="form-control" disabled="true" value="{{$permissioner->emp_name}}"/>
        @endif
      @endforeach
      <div class="radio">
          @if($content->permission_2 === 1)
            <label><input type="radio" checked="true" disabled />Yes</label>
            <label><input type="radio" disabled />No</label>
          @elseif($content->permission_2 === 2)
            <label><input type="radio" disabled />Yes</label>
            <label><input type="radio" checked="true" disabled />No</label>
          @else
            <label><input type="radio" disabled />Yes</label>
            <label><input type="radio" disabled />No</label>
          @endif
      </div>
      <label>Note:</label>
        <textarea class="form-control" disabled >{{$content->reason}}</textarea>
      <hr/>
	</form>
	<script type="text/javascript">
	</script>
	@endforeach
@endsection
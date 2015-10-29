@extends('layout.default')

@section('head')
  @if(session('status') == "Success!" && session('status') != "")
    <div class="alert alert-success">
      <h4>{{session('status')}}</h4>
    </div>
  @elseif(session('status') != "")
    <div class="alert alert-warning">
      <h4>{{session('status')}}</h4>
    </div>
  @endif
  <div class="well well-sm">
    <h1>
      Manage Employee Accounts
    </h1>  
  </div>
@endsection

@section('content')
  
  <div class="row">
    <div class="col-md-2"><button class="btn btn-info" data-toggle="modal" data-target="#entitlement" ><span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span> Change Entitlements</button></div>
  </div>
  <br/>
  <div class="row">
    
  </div>

  <button class="btn btn-info" data-toggle="modal" data-target="#department" ><span class="glyphicon glyphicon-plus" aria-hidden="true" ></span> Add New Department</button>
  <button class="btn btn-info" data-toggle="modal" data-target="#position" ><span class="glyphicon glyphicon-plus" aria-hidden="true" ></span> Add New Position</button>
  <button class="btn btn-info" data-toggle="modal" data-target="#schedule" ><span class="glyphicon glyphicon-plus" aria-hidden="true" ></span> Add New Schedule</button>
  <button class="btn btn-info" data-toggle="modal" data-target="#Deletedepartment" ><span class="glyphicon glyphicon-remove" aria-hidden="true" ></span> Delete Department</button>
  <button class="btn btn-info" data-toggle="modal" data-target="#Deleteposition" ><span class="glyphicon glyphicon-remove" aria-hidden="true" ></span> Delete Position</button>
  <button class="btn btn-info" data-toggle="modal" data-target="#Deleteschedule" ><span class="glyphicon glyphicon-remove" aria-hidden="true" ></span> Delete Schedule</button>
  
  <br/>
  <br/>
  <table id="example">
    <thead>
      <tr>
        <th>ID Number</th>
        <th>Name</th>
        <th>Position</th>
        <th>Email</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
        <tr>
        <td>{{$user->username}}</td>
        <td>{{$user->emp_name}}</td>
        <td>{{$user->position_name}}</td>
        <td>{{$user->email}}</td>
        <td>
          <a href="{{URL::to('accounts/show/' . $user->id)}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>&nbsp;|&nbsp;
          <a href="{{URL::to('accounts/resetPassword/' . $user->id)}}"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Reset Password</a>
        </td>
        </tr>
    @endforeach
    </tbody>
  </table>

  <div class="modal fade" id="entitlement" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h2>Entitlements:</h2>
                  <hr/>
                </div>
                <div class="modal-body">
                  <form action="{{URL::to('accounts/changeEntitlement')}}" method="POST" >
                    <?php echo Form::token() ?>
                    <label>Vacation Leave Entitlement:</label>
                    <input type="number" class="form-control" name="VL_entitlement" value="0" />
                    <label>Sick Leave Entitlement:</label>
                    <input type="number" class="form-control" name="SL_entitlement" value="0" />
                    <label>Maternal Leave Entitlement:</label>
                    <input type="number" class="form-control" name="ML_entitlement" value="0" />
                    <label>Paternal Leave Entitlement:</label>
                    <input type="number" class="form-control" name="PL_entitlement" value="0" />
                    <br/>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                  </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

      <div class="modal fade" id="department" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h2>Add New Department:</h2>
                  <hr/>
                </div>
                <div class="modal-body">
                  <form action="{{URL::to('accounts/addDepartment')}}" method="POST" >
                    <?php echo Form::token() ?>
                    <input type="text" class="form-control" name="department_name" placeholder="Department Name" />
                    <br/>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                  </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

      <div class="modal fade" id="Deletedepartment" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h2>Delete Department:</h2>
                  <hr/>
                </div>
                <div class="modal-body">
                  <form action="{{URL::to('accounts/deleteDepartment')}}" method="POST" >
                    <?php echo Form::token() ?>
                    <select name="department" class="form-control">
                      @foreach($departments as $department)
                        <option value="{{$department->id}}">{{$department->department_name}}</option>
                      @endforeach
                    </select>
                    <br/>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                  </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

      <div class="modal fade" id="position" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h2>Add New Position:</h2>
                  <hr/>
                </div>
                <div class="modal-body">
                  <form action="{{URL::to('accounts/addPosition')}}" method="POST" >
                    <?php echo Form::token() ?>
                    <select class="form-control" name="department">
                      @foreach($departments as $department)
                        <option value="{{$department->id}}">{{$department->department_name}}</option>
                      @endforeach
                    </select>
                    <br/>
                    <input type="text" class="form-control" name="position_name" placeholder="Position Name" />
                    <br/>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                  </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

      <div class="modal fade" id="Deleteposition" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h2>Delete Position:</h2>
                  <hr/>
                </div>
                <div class="modal-body">
                  <form action="{{URL::to('accounts/deletePosition')}}" method="POST" >
                    <?php echo Form::token() ?>
                    <select name="position" class="form-control">
                      @foreach($positions as $position)
                        <option value="{{$position->id}}">{{$position->position_name}}</option>
                      @endforeach
                    </select>
                    <br/>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                  </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

        <div class="modal fade" id="schedule" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h2>Add New Schedule:</h2>
                  <hr/>
                </div>
                <div class="modal-body">
                  <form action="{{URL::to('accounts/addSchedule')}}" method="POST" >
                    <?php echo Form::token() ?>
                    <label>From:</label>
                    <input type="time" class="form-control" name="shift_from" />
                    <br/>
                    <label>To:</label>
                    <input type="time" class="form-control" name="shift_to" />
                    <br/>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                  </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

        <div class="modal fade" id="Deleteschedule" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h2>Delete Position:</h2>
                  <hr/>
                </div>
                <div class="modal-body">
                  <form action="{{URL::to('accounts/deleteSchedule')}}" method="POST" >
                    <?php echo Form::token() ?>
                    <select name="schedule" class="form-control">
                      @foreach($shifts as $shift)
                        <option value="{{$shift->id}}">{{$shift->shift_from}} - {{$shift->shift_to}}</option>
                      @endforeach
                    </select>
                    <br/>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                  </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
  <script>
  $(function(){
    $("#example").dataTable();
  })
  </script>
@endsection
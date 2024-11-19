
@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Teacher List (Total: {{ $getRecord->total() }})</h1>
          </div>

          <div class="col-sm-6" style="text-align: right;">
            <a href="{{ url('admin/teacher/add')}}" class="btn btn-primary">Add New Teacher</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
                <div class="card">
                <div class="card-header">
                  <h3 class="card-title"> Search Teacher</h3>
                </div>
                <form method="get" action="">
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-2">
                            <label >First Name</label>
                            <input type="text" class="form-control" value="{{ Request::get('name')}}" name="name"  placeholder="Name">
                        </div>
                        <div class="form-group col-md-2">
                            <label >Last Name</label>
                            <input type="text" class="form-control" value="{{ Request::get('last_name')}}" name="last_name"  placeholder="Last Name">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Email </label>
                            <input type="text" class="form-control" value="{{ Request::get('email')}}" name="email" placeholder="Email">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Marital Status </label>
                            <input type="text" class="form-control" value="{{ Request::get('marital_status')}}" name="marital_status" placeholder="Marital Status">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Current Address </label>
                            <input type="text" class="form-control" value="{{ Request::get('address')}}" name="address" placeholder="Current Address">
                        </div>
                        <div class="form-group col-md-2">
                            <label> Gender </label>
                              <select class="form-control" name="gender">
                                <option value="">Select Gender</option>
                                <option {{ (Request::get('gender')=='Male')? 'selected' : ''}} value="Male">Male</option>
                                <option {{ (Request::get('gender')=='Female')? 'selected' : ''}} value="Female">Female</option>
                                <option {{ (Request::get('gender')=='Other')? 'selected' : ''}} value="Other">Other</option>
                              </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Phone Number </label>
                            <input type="text" class="form-control" value="{{ Request::get('phone_number')}}" name="phone_number" 
                            placeholder="Phone Number">
                        </div>
                        <div class="form-group col-md-2">
                          <label>Status </label>
                            <select class="form-control" name="status">
                              <option value="">Select Status</option>
                              <option {{ (Request::get('status')== 0)? 'selected' : ''}} value="0">Active</option>
                              <option {{ (Request::get('status')== 1)? 'selected' : ''}} value="1">Inactive</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label> Date of Joining</label>
                            <input type="date" class="form-control" value="{{ Request::get('admission_date')}}" name="admission_date" 
                            placeholder="Admission Date">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Created Date </label>
                            <input type="date" class="form-control" value="{{ Request::get('date')}}" name="date">
                        </div>
                        <div class="form-group col-md-2">
                          <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                          <a href="{{ url('admin/teacher/list') }}"  class="btn btn-success"style="margin-top: 30px;">Reset</a>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                </form>

            </div>

        </div>
    </section>
<!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          @include('message')

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Teacher List</h3>
                <form action="{{ url('admin/teacher/export_teacher') }}" method="post" style="float: right;">
                  {{csrf_field()}} 
                  <input type="hidden" value="{{ Request::get('name')}}" name="name">
                  <input type="hidden" value="{{ Request::get('last_name')}}" name="last_name">
                  <input type="hidden" value="{{ Request::get('email')}}" name="email">
                  <input type="hidden" value="{{ Request::get('marital_status')}}" name="marital_status">
                  <input type="hidden" value="{{ Request::get('address')}}" name="address">
                  <input type="hidden" value="{{ Request::get('gender')}}" name="gender">
                  <input type="hidden" value="{{ Request::get('phone_number')}}" name="phone_number">
                  <input type="hidden" value="{{ Request::get('status')}}" name="status">
                  <input type="hidden" value="{{ Request::get('admission_date')}}" name="admission_date">
                  <input type="hidden" value="{{ Request::get('date')}}" name="date">    
                  <button type="submit" class="btn btn-primary btn-sm">Export Excel</button>
                </form>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow:auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Profile pic</th>
                      <th>Teacher Name</th>
                      <th>Email</th>
                      <th>Gender</th>
                      <th>Date of Birth</th>
                      <th>Date of Joining</th>
                      <th>Mobile Number</th>
                      <th>Marital Status</th>
                      <th>Current Address </th>
                      <th>Permanent Address</th>          
                      <th>Qualification</th>
                      <th>Work Experience</th>
                      <th>Note</th>
                      <th>Status</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                      <tr>
                        <td>{{ $value->id }}</td>
                        <td>
                          @if(!empty($value->getprofileDirect()))
                            <img src="{{ $value->getprofileDirect() }}" style="height:50px; width:50px; border-radius:50px">
                          @endif
                        </td>
                        <td>{{ $value->name }} {{ $value->middle_name}} {{ $value->last_name }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->gender }}</td>
                        <td>
                          @if(!empty( $value->date_of_birth ))
                            {{date('d-m-Y', strtotime( $value->date_of_birth ))}}
                          @endif
                        </td>
                        <td>
                          @if(!empty( $value->admission_date ))
                            {{date('d-m-Y', strtotime( $value->admission_date ))}}
                          @endif      
                        </td>
                        <td>{{ $value->phone_number  }}</td>
                        <td>{{ $value->marital_status }}</td>
                        <td>{{ $value->address }}</td>
                        <td>{{ $value->paddress }}</td>
                        <td>{{ $value->qualification }}</td>
                        <td>{{ $value->work_experience  }}</td>
                        <td>{{ $value->note }}</td>
                        <td>{{ ($value->status ==0)? 'Active': 'Inactive' }}</td>
                        
                        <td>{{ date('d-m-Y H: i A',strtotime($value->created_at))}}</td>
                        <td style="min-width:150px">
                          <a href="{{ url('admin/teacher/edit/'.$value->id) }}" class="btn btn-primary btn-sm">Edit</a>
                          <a href="{{ url('admin/teacher/delete/'.$value->id) }}" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                        
                </table>
                <div style="padding: 10px; float: right;">
                 
                </div>
              </div>
              <!-- /.card-body -->
            </div>
         
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
   
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection

@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Parent Student List ({{$getparent->name}}  {{$getparent->last_name}}) </h1>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

     <section class="content">
        <div class="container-fluid">
                <div class="card">
                <div class="card-header">
                  <h3 class="card-title"> Search Student</h3>
                </div>
                <form method="get" action="">
                    <div class="card-body">
                      <div class="row">
                      <div class="form-group col-md-2">
                            <label >Student ID</label>
                            <input type="text" class="form-control" value="{{ Request::get('id')}}" name="id"  placeholder="Student ID">
                        </div>
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
                          <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                          <a href="{{ url('admin/parent/my_student/'.$parent_id) }}"  class="btn btn-success"style="margin-top: 30px;">Reset</a>
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

  @if(!empty($getSearchStudent))
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Student List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow:auto;">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Profile pic</th>
                      <th>Student Name</th>
                      <th>Email</th>
                      <th>Parent Name</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($getSearchStudent as $value)
                      <tr>
                        <td>{{ $value->id }}</td>
                        <td>
                          @if(!empty($value->getprofile()))
                            <img src="{{ $value->getprofile() }}" style="height:50px; width:50%; border-radius:50px">
                          @endif
                        </td>
                        <td>{{ $value->name }} {{ $value->middle_name  }} {{ $value->last_name }}</td>
                        <td>{{ $value->email }}</td> 
                        <td>{{ $value->parent_name }}  {{ $value->parent_last_name }}</td> 
                        <td>{{ date('d-m-Y H: i A',strtotime($value->created_at))}}</td>
                        <td style="min-width:150px">
                          <a href="{{ url('admin/parent/assign_student_parent/'.$value->id.'/'.$parent_id) }}" 
                          class="btn btn-primary btn-sm">Add Student to Parent</a>
                         
                      </tr>
                    @endforeach
                    
                  </tbody>
                </table>
                <div style="padding: 10px; float: right;">
                 
                </div>
              </div>
              <!-- /.card-body -->
            </div>
  @endif       

            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Parent Student List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow:auto;">
              <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Profile pic</th>
                      <th>Student Name</th>
                      <th>Email</th>
                      <th>Parent Name</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($getRecord as $value)
                      <tr>
                        <td>{{ $value->id }}</td>
                        <td>
                          @if(!empty($value->getprofile()))
                            <img src="{{ $value->getprofile() }}" style="height:50px; width:50%; border-radius:50px">
                          @endif
                        </td>
                        <td>{{ $value->name }} {{ $value->middle_name  }} {{ $value->last_name }}</td>
                        <td>{{ $value->email }}</td> 
                        <td>{{ $value->parent_name }}  {{ $value->parent_last_name }}</td> 
                        <td>{{ date('d-m-Y H: i A',strtotime($value->created_at))}}</td>
                        <td style="min-width:150px">

                          <a href="{{ url('admin/parent/assign_student_parent_delete/'.$value->id) }}" class="btn btn-danger btn-sm">Delete</a>
                         
                      </tr>
                    @endforeach
                    
                  </tbody>
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
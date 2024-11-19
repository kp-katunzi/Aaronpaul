
@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My  Student  </h1>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          @include('message')
            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">My  Student </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow:auto;">
              <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Profile pic</th>
                      <th>Student Name</th>
                      <th>Email</th>
                      <th>Gender</th>
                      <th>Date of Birth</th>
                      <th>Religion</th>
                      <th>Admission Number</th>
                      <th>Class</th>
                      <th>Phone Number</th>
                      <th>Admission Date</th>
                      <th>Blood Group</th>
                      <th>Height</th>
                      <th>Weight</th>
                      <th>NIDA</th>
                      <!-- <th>Action</th> -->
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($getRecord as $value)
                        <td>
                            @if(!empty($value->getprofileDirect()))
                                <img src="{{ $value->getprofileDirect() }}" style="height:50px; width:50px; border-radius:50px">
                            @endif
                            </td>
                            <td>{{ $value->name }} {{ $value->middle_name  }} {{ $value->last_name }}</td>
                            <td>{{ $value->email }}</td>
                            <td>{{ $value->gender }}</td>
                            <td style="min-width:150px;">
                            @if(!empty( $value->date_of_birth ))
                                {{date('d-m-Y', strtotime( $value->date_of_birth ))}}
                            @endif
                            </td>
                            <td>{{ $value->religion }}</td>
                            <td style="min-width: 150px;">{{ $value->admission_number }}</td>
                            <td>{{ $value->class_name }}</td>
                            <td>{{ $value->phone_number  }}</td>
                            <td style="min-width: 100px;">
                            @if(!empty( $value->admission_date ))
                                {{date('d-m-Y', strtotime( $value->admission_date ))}}
                            @endif      
                            </td>
                            <td>{{ $value->blood_group  }}</td>
                            <td>{{ $value->height }}</td>
                            <td>{{ $value->weight  }}</td>
                            <td>{{ $value->nida}}</td>  
                            <td style="min-width: 150px;">
                            <a href="{{ url('parent/my_student/exam_result/'.$value->id) }}" class="btn btn-primary btn-sm">Exam Result</a>
                            </td>  
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
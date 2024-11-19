
@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> My Class & Subject</h1>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">


            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> My Class & Subject</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Class Name</th>
                      <th>Subject Name</th>
                      <th>Subject Type</th>
                      <th>My Class Timetable</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                        <tr>
                          <td>{{ $value->class_name }}</td>
                          <td>{{ $value->subject_name }}</td>  
                          <td>{{ $value->subject_type }}</td>    
                          <td>
                            @php
                            $ClassSubject = $value->getMyTimetable($value->class_id, $value->subject_id);
                            @endphp
                            @if(!empty($ClassSubject))
                              {{ date('h:i A', strtotime( $ClassSubject->start_time)) }} to 
                               {{  date('h:i A', strtotime($ClassSubject->end_time))  }}
                               <br/>
                               Room Number: {{$ClassSubject->room_number}}
                            @endif
                           
                          </td>    
                          <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                          <td>
                            <a href="{{ url('teacher/my_class_subject/my_class_timetable/'. $value->class_id.'/'.
                            $value->subject_id )}}" class="btn btn-primary">My Class Timetable</a>
                          </td>
                        </tr>
                      @endforeach  
                  </tbody>
                </table>
               
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
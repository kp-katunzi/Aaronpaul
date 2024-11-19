
@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Marks Register </h1>
          </div>

          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
                <div class="card">
                <div class="card-header">
                  <h3 class="card-title"> Search Marks Register</h3>
                </div>

                <form method="get" action="">
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-3">
                            <label >Exam </label>
                            <select class="form-control" name="exam_id" required>
                            <option value="">Select</option>
                                @foreach($getExam as $exam)
                                    <option {{(Request::get('exam_id') == $exam->id) ? 'selected' : ''}} value="{{ $exam->id}}">{{ $exam->name}}</option>
                                @endforeach     
                                
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label >Class </label>
                            <select class="form-control" name="class_id" required>
                            <option  value="">Select</option>
                                @foreach($getClass as $class)
                                    <option {{(Request::get('class_id') == $class->id) ? 'selected' : ''}} value="{{ $class->id}}">{{ $class->name}}</option>
                                @endforeach     
                            </select>
                        </div>
                       
                        <div class="form-group col-md-3">
                          <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                          <a href="{{ url('admin/examinations/marks_register') }}"  class="btn btn-success"style="margin-top: 30px;">Reset</a>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                </form>

            </div>

        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

          @include('message')
          
        @if(!empty($getSubject) && !empty($getSubject->count()))
           <div class="card">
              <div class="card-header">
                <h3 class="card-title">Marks Register</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow: auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>STUDENT</th>
                      @foreach($getSubject as $subject)
                        <th>{{ $subject->subject_name}} <br/>
                            ({{ $subject->subject_type }} : {{ $subject->passing_marks}}/{{ $subject->full_marks}})
                        </th>
                      @endforeach  
                      <th>ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(!empty($getStudent) && !empty($getStudent->count()))
                        @foreach($getStudent as $student)
                            <form method="post" class="SubmitForm">
                                 {{csrf_field()}} 
                                 <input type="hidden" name="student_id" value="{{ $student->id }}">
                                 <input type="hidden" name="exam_id" value="{{ Request::get('exam_id')}}">
                                 <input type="hidden" name="class_id" value="{{ Request::get('class_id')}}">
                                <tr>
                                    <td>{{ $student->name }} {{ $student->middle_name }} {{ $student->last_name }}</td>

                                        @php
                                            $i = 1;
                                            $totalStudentMarks = 0;
                                            $totalFullMarks = 0;
                                            $totalPassingMarks = 0;
                                            $pass_fail_val = 0;
                                        @endphp
                                    @foreach($getSubject as $subject)

                                        @php
                                            $totalMark = 0;
                                            $totalFullMarks =  $totalFullMarks + $subject->full_marks;
                                            $totalPassingMarks =  $totalPassingMarks + $subject->passing_marks;
                                            $getMark =  $subject->getMark( $student->id, Request::get('exam_id'),  Request::get('class_id'), $subject->subject_id);

                                            if(!empty( $getMark))
                                            {
                                                $totalMark = $getMark->test_one + $getMark->test_two + $getMark->exam;
                                            }
                                            $totalStudentMarks =    $totalStudentMarks + $totalMark;
                                        @endphp
                                        <td>
                                            <div style="margin-bottom: 10px;">
                                                Test One
                                                <input type="hidden" name="mark[{{ $i }}][full_marks]"  value="{{ $subject->full_marks }}">
                                                <input type="hidden" name="mark[{{ $i }}][passing_marks]"  value="{{ $subject->passing_marks }}">
                                                <input type="hidden" name="mark[{{ $i }}][id]"  value="{{ $subject->id }}">
                                                <input type="hidden" name="mark[{{ $i }}][subject_id]"  value="{{ $subject->subject_id }}">
                                                <input type="text" name="mark[{{ $i }}][test_one]" id="test_0ne_{{ $student->id }}{{ $subject->subject_id}}" style="width: 200px;" placeholder="Enter marks" 
                                                value="{{!empty($getMark->test_one) ? $getMark->test_one : ''}}" class="form-control">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                            Test Two
                                            <input type="text" name="mark[{{ $i }}][test_two]" id="test_two_{{ $student->id }}{{ $subject->subject_id}}" style="width: 200px;" placeholder="Enter marks" 
                                            value="{{!empty($getMark->test_two) ? $getMark->test_two : ''}}"  class="form-control">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                            Exam
                                            <input type="text" name="mark[{{ $i }}][exam]" id="exam_{{ $student->id }}{{ $subject->subject_id}}" style="width: 200px;" placeholder="Enter marks"
                                            value="{{!empty($getMark->exam) ? $getMark->exam : ''}}"  class="form-control">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <button type="button" class="btn btn-primary saveSingleSubject" id="{{ $student->id }}"  data-val="{{ $subject->subject_id}}" data-exam="{{ Request::get('exam_id')}}"
                                                data-schedule=" {{ $subject->id }}"   data-class="{{ Request::get('class_id')}}">Save</button>
                                            </div> 
                                            @if(!empty( $getMark)) 
                                                <div style="margin-bottom: 10px;">
                                                    <b>Total Mark: </b> {{ $totalMark }} <br/>
                                                    <b>Passing Mark: </b> {{ $subject->passing_marks}}
                                                    <br/>
                                                    @php
                                                      $getLoopGrade = App\Models\MarksGradeModel::getGrade($totalMark); 
                                                    @endphp
                                                    @if(!empty( $getLoopGrade))
                                                      <b>Grade: </b> {{ $getLoopGrade }} <br/>
                                                    @endif
                                                    @if($totalMark >= $subject->passing_marks)
                                                        Result: <span style="color: green; font-weight:bold;">Pass</span>
                                                    @else
                                                        Result: <span style="color: red; font-weight:bold;">Fail</span>
                                                        @php
                                                            $pass_fail_val = 1; 
                                                        @endphp
                                                    @endif    
                                                </div>
                                            @endif
                                        </td>
                                        @php
                                         $i++; 
                                        @endphp
                                    @endforeach 
                                    <td style="min-width: 250px;">
                                        <button type="submit" class="btn btn-success">Save</button>
                                      
                                        <a class="btn btn-primary  target="blank" href="{{ url('admin/my_exam_result/print?exam_id='
                                        .Request::get('exam_id').'&student_id='.$student->id) }}">Print</a>
                                        @if(!empty( $totalStudentMarks))  
                                            <br> <br>
                                            <b>Total Subject Marks:</b> {{ $totalFullMarks }}
                                            <br>
                                            <b>Total Passing Marks: </b>{{ $totalPassingMarks }}
                                            <br>
                                            <b>Total Student Marks:</b> {{ $totalStudentMarks }}
                                            <br><br>
                                            @php
                                                $percentage = ($totalStudentMarks*100)/$totalFullMarks ;
                                                $getGrade = App\Models\MarksGradeModel::getGrade( $percentage );
                                                                   
                                            @endphp
                                            <b>Percentage: </b>{{ number_format($percentage, 2) }}%
                                                <br/>
                                                @if(!empty( $getGrade))
                                                 <b>Grade: </b>{{  $getGrade }}
                                                @endif

                                                <br/>
                                            @if( $pass_fail_val == 0)
                                                Result: <span style="color: green; font-weight:bold;">Pass</span>
                                            @else
                                               Result:  <span style="color: red; font-weight:bold;">Fail</span>
                                            @endif
                                        @endif
                                    </td> 
                    
                                </tr>
                            </form>
                        @endforeach
                    @endif
   
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
        @endif
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


@section('script')

 <script type="text/javascript">
    $('.SubmitForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "{{ url('admin/examinations/submit_marks_register')}}",
            data : $(this).serialize(),
            dataType:"json",
            success: function(data) {
                alert(data.message);

            }
        });

    });

    $('.saveSingleSubject').click(function(e) {
        e.preventDefault();
        var student_id = $(this).attr('id');
        var subject_id = $(this).attr('data-val');
        var exam_id = $(this).attr('data-exam');
        var class_id = $(this).attr('data-class');
        var id = $(this).attr('data-schedule');
        var test_one = $('#test_0ne_'+student_id+ subject_id).val();
        var test_two = $('#test_two_'+student_id+ subject_id).val();
        var exam = $('#exam_'+student_id+ subject_id).val();

        $.ajax({
            type: "POST",
            url: "{{ url('admin/examinations/single_submit_marks_register')}}",
            data : {
                '_token': "{{ csrf_token() }}",
                id :  id,
                student_id :student_id,
                subject_id :  subject_id,
                exam_id :  exam_id,
                class_id :  class_id,
                test_one :  test_one,
                test_two :  test_two,
                exam : exam

            },
            dataType:"json",
            success: function(data) {
                alert(data.message);

            }
        });


    })

</script>



@endsection
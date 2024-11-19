
@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> My Exam Result </h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            @foreach($getRecord as $value)
                <div class="col-md-12">
                    <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> {{$value['exam_name']}}</h3>
                        <!-- <a class="btn btn-primary btn-sm float-right" target="blank" href="{{ url('student/my_exam_result/print?exam_id='
                        .$value['exam_id'].'&student_id='.Auth::user()->id) }}">Print</a> -->

                    </div>
                    <div class="card-body p-0" style="overflow: auto;">
                        <table class="table table-striped">
                        <thead>
                            <tr>
                            <th>Subject</th>
                            <th>Test One</th> 
                            <th>Test Two</th> 
                            <th>Exam</th> 
                            <th>Total Score</th> 
                            <th>Paasing Marks</th>
                            <th>Full Marks</th>
                            <th>Result</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @php
                                $total_score = 0;
                                $full_marks = 0;
                                $result_validation = 0;
                            @endphp
                            @foreach($value['subject'] as $exam)
                                @php
                                    $total_score = $total_score + $exam['total_score'];
                                    $full_marks = $full_marks + $exam['full_marks'];
                                @endphp
                                <tr>
                                    <td>{{ $exam['subject_name']}}</td>
                                    <td>{{ $exam['test_one']}}</td>
                                    <td>{{ $exam['test_two']}}</td>
                                    <td>{{ $exam['exam']}}</td>
                                    <td>{{ $exam['total_score']}}</td>
                                    <td>{{ $exam['passing_marks']}}</td>
                                    <td>{{ $exam['full_marks']}}</td>
                                    <td>
                                       @if($exam['total_score'] >= $exam['passing_marks'] )
                                        <span style="color: green; font-weight:bold;">Pass</span>
                                       @else
                                        @php
                                            $result_validation =1;
                                        @endphp
                                        <span style="color: red; font-weight:bold;">Fail</span>
                                       @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2">
                                    <b>Grand Total: {{ $total_score }}/{{ $full_marks }}</b>
                                </td>
                                <td colspan="2">
                                    @php
                                        $percentage = ($total_score*100)/$full_marks;
                                        $getGrade = App\Models\MarksGradeModel::getGrade( $percentage );  
                                    @endphp
                                    <b>Percentage: {{round( $percentage, 2) }}%</b>
                                </td>
                                <td colspan="2">
                                    <b>Grade : {{ $getGrade }}</b>
                                </td>
                                <td colspan="3">
                                    <b>Result: 
                                             @if( $result_validation==0)
                                                <span style="color: green; ">Pass</span>
                                            @else
                                                <span style="color: red; ">Fail</span>
                                             @endif
                                            </b>
                                                
                                </td>
                            </tr>      
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            @endforeach
        </div>
      </div>
    </section>
  </div>
@endsection
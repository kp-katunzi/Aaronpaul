
@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Collect Fees Report </h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-12"> 
          <div class="card">
                <div class="card-header">
                  <h3 class="card-title"> Search Student</h3>
                </div>

                <form method="get" action="">
                    <div class="card-body">
                      <div class="row"> 

                      <div class="form-group col-md-2">
                            <label >Student ID </label>
                            <input type="text" class="form-control" value="{{ Request::get('student_id')}}" name="student_id"  placeholder="Student ID">
                        </div>

                        <div class="form-group col-md-2">
                            <label >Student First Name</label>
                            <input type="text" class="form-control" value="{{ Request::get('name')}}" name="student_name"  placeholder="Name">
                        </div>

                        <div class="form-group col-md-2">
                            <label >Student Last Name</label>
                            <input type="text" class="form-control" value="{{ Request::get('last_name')}}" name="student_last_name"  placeholder="Last Name">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Class </label>
                           <select class="form-control" name="class_id" id="">
                            <option value="">Select</option>
                            @foreach($getClass as $class)
                                <option {{ (Request::get('class_id') == $class->id)? 'selected' : ''}} 
                                     value="{{  $class->id }}">{{ $class->name }}</option>
                            @endforeach
                           </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Start Created Date </label>
                            <input type="date" class="form-control" value="{{ Request::get('start_created_date')}}" name="start_created_date" >
                        </div>

                        <div class="form-group col-md-2">
                            <label>End Created Date </label>
                            <input type="date" class="form-control" value="{{ Request::get('end_created_date')}}" name="end_created_date" 
                           >
                        </div>

                        <div class="form-group col-md-2">
                          <label>Payment Type </label>
                            <select class="form-control" name="payment_type">
                              <option value="">Select</option>
                              <option {{ (Request::get('payment_type')== 'Cash')? 'selected' : ''}} value="Cash">Cash</option>
                              <option {{ (Request::get('payment_type')== 'Cheque')? 'selected' : ''}} value="Cheque"Cheque>Cheque</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                          <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                          <a href="{{ url('admin/fees_collection/collect_fees_report') }}"  class="btn btn-success"style="margin-top: 30px;">Reset</a>
                        </div>

                      </div>
                    </div>
                    <!-- /.card-body -->
                </form>

            </div>


          
                @include('message')
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Collect Fees Report </h3>
                <form style="float: right;" action="{{ url('admin/fees_collection/export_collect_fees_report')}}" method="post">
                  {{csrf_field()}} 
                  <input type="hidden"  value="{{ Request::get('name')}}" name="student_name">
                  <input type="hidden"  value="{{ Request::get('student_last_name')}}" name="student_last_name">
                  <input type="hidden"  value="{{ Request::get('class_id')}}" name="class_id">
                  <input type="hidden"  value="{{ Request::get('start_created_date')}}" name="start_created_date">
                  <input type="hidden"  value="{{ Request::get('end_created_date')}}" name="end_created_date">
                  <input type="hidden"  value="{{ Request::get('payment_type')}}" name="payment_type">
                  <button type="submit" class="btn btn-primary btn-sm" >Export Excel</button>
                </form>
              </div>
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                      <th>Class Name</th>
                      <th>Total Amount</th>
                      <th>Paid Amount</th>
                      <th>Remaining Amount</th>
                      <th>Payment Type</th>
                      <th>Remark</th>
                      <th>Created By</th>
                      <th>Created Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($getRecord as $value)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->student_id }}</td>
                            <td>{{ $value->first_name }}  {{ $value->middle_name }}  {{ $value->last_name }}</td>
                            <td>{{ $value->class_name }}</td>
                            <td>Tsh {{ number_format($value->total_amount,2) }}</td>
                            <td>Tsh {{ number_format( $value->paid_amount, 2) }}</td>
                            <td>Tsh {{ number_format($value->remaining_amount) }}</td>
                            <td>{{ $value->payment_type }}</td>
                            <td>{{ $value->remark  }}</td>
                            <td>{{ $value->created_name }}</td>
                            <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%">Record not found</td>
                        </tr>
                        @endforelse
                        
                  </tbody>
                </table> 
                <div style="padding: 10px; float: right;">
                  {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                </div>    
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection

@section('script')

@endsection

@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add New Student</h1>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="card card-primary">
                <form method="post" action="" enctype="multipart/form-data">
                    {{csrf_field()}} 
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label >First Name  <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" value="{{ old('name') }}"
                                 name="name" required placeholder="First Name">
                                 <div style="color:red;">{{ $errors->first('name') }}</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label >Middle Name <span style="color:red;">*</span> </label>
                                <input type="text" class="form-control" value="{{ old('middle_name') }}" 
                                name="middle_name" required placeholder="Middle Name">
                                <div style="color:red;">{{ $errors->first('middle_name') }}</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label >Last Name <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" value="{{ old('last_name') }}" 
                                name="last_name" required placeholder="Last Name">
                                <div style="color:red;">{{ $errors->first('last_name') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label > Gender   <span style="color:red;">*</span> </label>
                                <select class="form-control" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option {{ (old('gender')=='Male')? 'selected' : ''}} value="Male">Male</option>
                                    <option {{ (old('gender')=='Female')? 'selected' : ''}} value="Female">Female</option>
                                    <option {{ (old('gender')=='Other')? 'selected' : ''}} value="Other">Other</option>
                                </select>
                                <div style="color:red;">{{ $errors->first('gender') }}</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label >Date of Birth<span style="color:red;">*</span></label>
                                <input type="date" class="form-control" required value="{{ old('date_of_birth') }}" 
                                name="date_of_birth">
                                <div style="color:red;">{{ $errors->first('date_of_birth') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label >Marital Status <span style="color:red;">*</span> </label>
                                <input type="text" class="form-control" value="{{ old('marital_status') }}" 
                                name="marital_status" required placeholder="Marital Status">
                                <div style="color:red;">{{ $errors->first('marital_status') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label >Current Address <span style="color:red;">*</span> </label>
                                <input type="text" class="form-control" value="{{ old('address') }}" 
                                name="address" required placeholder="Current Address">
                                <div style="color:red;">{{ $errors->first('address') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label >Permanent Address<span style="color:red;"></span>  </label>
                                <input type="text" class="form-control" value="{{ old('paddress') }}" 
                                name="paddress" placeholder="Permanent Address">
                                <div style="color:red;">{{ $errors->first('paddress') }}</div>
                            </div>

                            

                            <div class="form-group col-md-6">
                                <label >Mobile Number <span style="color:red;"></span> </label>
                                <input type="text" class="form-control" value="{{ old('phone_number') }}" 
                                name="phone_number"  placeholder="Phone Number ">
                                <div style="color:red;">{{ $errors->first('phone_number') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label >Date of Joining<span style="color:red;">*</span> </label>
                                <input type="date" class="form-control" value="{{ old('admission_date') }}" 
                                name="admission_date" required placeholder="Admission Date ">
                                <div style="color:red;">{{ $errors->first('admission_date') }}</div>
                            </div>

                            
                            <div class="form-group col-md-6">
                                <label >Profile pic <span style="color:red;"></span> </label>
                                <input type="file" class="form-control" name="profile_photo">
                                <div style="color:red;">{{ $errors->first('profile_photo') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label >Qualification<span style="color:red;"></span> </label>
                                <input type="text" class="form-control" name="qualification" value="{{ old('qualification ') }}"
                                 placeholder="Qualification">
                                 <div style="color:red;">{{ $errors->first('qualification') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label >Work Experience  <span style="color:red;"></span> </label>
                                <input type="text" class="form-control" name="work_experience" value="{{ old('work_experience') }}" placeholder="Work Experience">
                                <div style="color:red;">{{ $errors->first('work_experience') }}</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label >Note   <span style="color:red;"></span> </label>
                                <input type="text" class="form-control" name="note" value="{{ old('note') }}" placeholder="Note">
                                <div style="color:red;">{{ $errors->first('note') }}</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label > Status   <span style="color:red;">*</span> </label>
                                <select class="form-control" name="status" required>
                                    <option value="">Select Status</option>
                                    <option  {{ (old('status') == 0)? 'selected' : ''}} value="0">Active</option>
                                    <option  {{ (old('status') == 1)? 'selected' : ''}} value="1">Inactive</option>
                                </select>
                                <div style="color:red;">{{ $errors->first('status') }}</div>
                            </div>
                        </div>

                        <br/>
                            
                        <div class="form-group">
                            <label>Email <span style="color:red;">*</span> </label>
                            <input type="email" class="form-control" value="{{ old('email') }}" name="email" required placeholder="Email">
                            <div style="color:red;">{{ $errors->first('email') }}</div>
                        </div>

                        <div class="form-group">
                            <label>Password  <span style="color:red;">*</span> </label>
                            <input type="password" class="form-control" name="password" required placeholder="Password">
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
            
                    </div>
                         
                    
                        </div>
        
                         
                    </div>
        <!-- /.card-body -->

                </form>

            </div>
       
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
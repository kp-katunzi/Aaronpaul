
@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>My Account</h1>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <!-- left column -->
            <div class="col-md-12">

            @include('message')
            
                <div class="card card-primary">
                <form method="post" action="" enctype="multipart/form-data">
                    {{csrf_field()}} 
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label >First Name  <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" value="{{ old('name', $getRecord->name) }}"
                                 name="name" required placeholder="First Name">
                                 <div style="color:red;">{{ $errors->first('name') }}</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label >Last Name <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" value="{{ old('last_name', $getRecord->last_name) }}" 
                                name="last_name" required placeholder="Last Name">
                                <div style="color:red;">{{ $errors->first('last_name') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label > Gender   <span style="color:red;">*</span> </label>
                                <select class="form-control" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option {{ (old('gender', $getRecord->gender)=='Male')? 'selected' : ''}} value="Male">Male</option>
                                    <option {{ (old('gender', $getRecord->gender)=='Female')? 'selected' : ''}} value="Female">Female</option>
                                    <option {{ (old('gender', $getRecord->gender)=='Other')? 'selected' : ''}} value="Other">Other</option>
                                </select>
                                <div style="color:red;">{{ $errors->first('gender') }}</div>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label >Phone Number <span style="color:red;">*</span> </label>
                                <input type="text" class="form-control" required value="{{ old('phone_number', $getRecord->phone_number) }}" 
                                name="phone_number"  placeholder="Phone Number">
                                <div style="color:red;">{{ $errors->first('phone_number') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label >Occupation  <span style="color:red;"></span> </label>
                                <input type="text" class="form-control" name="occupation" value="{{ old('occupation', $getRecord->occupation) }}" placeholder="Occupation">
                                <div style="color:red;">{{ $errors->first('occupation') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label >Address   <span style="color:red;">*</span> </label>
                                <input type="text" class="form-control" required name="address" value="{{ old('address', $getRecord->address) }}" placeholder="Address">
                                <div style="color:red;">{{ $errors->first('address') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label >Profile pic <span style="color:red;"></span> </label>
                                <input type="file" class="form-control" name="profile_photo">
                                <div style="color:red;">{{ $errors->first('profile_photo') }}</div>
                                @if(!empty($getRecord->getprofile()))
                                    <img src="{{ $getRecord->getprofile() }}" style=" width:aauto; height: 50px;">
                                @endif
                            </div>
                       
                        </div>
                        <br/>
                            
                        <div class="form-group">
                            <label>Email <span style="color:red;">*</span> </label>
                            <input type="email" class="form-control" value="{{ old('email', $getRecord->email) }}" name="email" required placeholder="Email">
                            <div style="color:red;">{{ $errors->first('email') }}</div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
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
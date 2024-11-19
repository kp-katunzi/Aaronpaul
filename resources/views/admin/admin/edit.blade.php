
@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit  Admin</h1>
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
                <form method="post" action=""  enctype="multipart/form-data">
                    {{csrf_field()}} 
                    <div class="card-body">
                        <div class="form-group">
                            <label >Name</label>
                            <input type="text" class="form-control" name="name"  value="{{ old('name', $getRecord->name ) }}" required placeholder="Name">
                        </div>

                        
                        <div class="form-group">
                            <label >Profile pic <span style="color:red;"></span> </label>
                            <input type="file" class="form-control" name="profile_photo">
                            <div style="color:red;">{{ $errors->first('profile_photo') }}</div>
                            @if(!empty($getRecord->getprofile()))
                                <img src="{{ $getRecord->getprofile() }}" style=" width:auto; height: 50px;">
                             @endif
                         </div>

                        <div class="form-group">
                            <label>Email </label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $getRecord->email ) }}" required placeholder="Email">
                            <div style="color:red;">{{ $errors->first('email') }}</div>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password"  placeholder="Password">
                            <p>Due you want to change password so Please add new password </p>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>

            </div>
       
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
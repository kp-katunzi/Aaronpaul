
@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add New Marks Grade</h1>
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
                <form method="post" action="">
                    {{csrf_field()}} 
                    <div class="card-body">
                        <div class="form-group">
                            <label > Grade Name</label>
                            <input type="text" class="form-control" value="{{ old('name') }}" name="name" required placeholder="Name">
                        </div>

                        <div class="form-group">
                            <label > Percentage From</label>
                            <input type="number" class="form-control" value="{{ old('percentage_from') }}" name="percentage_from" required placeholder="">
                        </div>

                        <div class="form-group">
                            <label >Percentage To</label>
                            <input type="number" class="form-control" value="{{ old('percentage_to') }}" name="percentage_to" required placeholder="">
                        </div>
                       
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
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
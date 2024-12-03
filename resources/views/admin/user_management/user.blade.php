@extends('layouts.app')

@section('style')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('message')

                    <div class="card mt-5">
                        <div class="card-body">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>User Role</th>
                                        <th>Created Date</th>
                                        <th width="120px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
       
        $(document).ready(function() {
    $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('admin/User_Management/view_users') }}",
        columns: [
            {  data: 'id', name: 'id' },
            {  data: 'name', name: 'name' },
            {  data: 'email', name: 'email'},
            {  data: 'user_type', name: 'user_type',},
            {  data: 'created_at', name: 'created_at'},
            { 
                data: 'action', name: 'action', orderable: false, searchable: false 
            }
        ]
    });
});

    </script>
@endsection

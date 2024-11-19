
@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Setting</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-12">
                
            @include('message')

                <div class="card card-primary">
                <form method="post" action=""  enctype="multipart/form-data">
                    {{csrf_field()}} 
                    <div class="card-body">
                        <div class="form-group">
                            <label >Logo <span style="color:red;"></span> </label>
                            <input type="file" class="form-control" name="logo">
                            @if(!empty($getRecord->getLogo()))
                                <img src="{{ $getRecord->getLogo() }}" style=" width:auto; height: 50px;">
                             @endif    
                         </div>

                        <div class="form-group">
                            <label >Favicon Icon <span style="color:red;"></span> </label>
                            <input type="file" class="form-control" name="favicon_icon">
                            @if(!empty($getRecord->getFavicon()))
                                <img src="{{ $getRecord->getFavicon() }}" style=" width:auto; height: 50px;">
                             @endif                          
                         </div>

                         <div class="form-group">
                            <label >Fevicon Login <span style="color:red;"></span> </label>
                            <input type="file" class="form-control" name="favicon_login">
                            @if(!empty($getRecord->getFaviconLogin()))
                                <img src="{{ $getRecord->getFaviconLogin() }}" >
                             @endif
                           
                         </div>

                         <div class="form-group">
                            <label>College Name </label>
                            <input type="text" class="form-control" name="college_name" value="{{ $getRecord->college_name  }}">  
                        </div>
                        <div class="form-group">
                            <label>Exam Description </label>
                            <textarea class="form-control" name="exam_description" >{{ $getRecord->exam_description }}</textarea>                           
                        </div>
                    </div>            
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>      
            </div>        
        </div> 
        </section>      
    </div>
@endsection
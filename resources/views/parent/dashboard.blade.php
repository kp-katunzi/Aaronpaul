
 
@extends('layouts.app')

@section('content')

 <div class="content-wrapper">
   <div class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-12">
           <h1 class="m-0">Dashboard</h1>
         </div>
       </div>
     </div>
   </div>

   <section class="content">
     <div class="container-fluid">
       <div class="row">
       <div class="col-lg-3 col-6">
           <div class="small-box bg-success">
             <div class="inner">
               <h3>{{ $totalStudent}}</h3>
               <p>Total Student</p>
             </div>
             <div class="icon">
               <i class="fas fa-user-graduate"></i>
             </div>
             <a href="{{ url('parent/my_student') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
           </div>
         </div>

         <div class="col-lg-3 col-6">
           <div class="small-box bg-success">
             <div class="inner">
             <h3>{{ $totalNoticeBoard }}</h3>
               <p>Total Notice Board</p>
             </div>
             <div class="icon">
               <i class="fas fa-book-reader"></i>
             </div>
             <a href="{{ url('parent/my_notice_board') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
           </div>
         </div>

       </div>
     </div>
   </section>
 </div>
@endsection
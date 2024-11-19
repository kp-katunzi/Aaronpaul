
 
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
             <a href="{{ url('teacher/my_student') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
           </div>
         </div>
       
         <div class="col-lg-3 col-6">
           <div class="small-box bg-primary">
             <div class="inner">
               <h3>{{ $totalClass }}</h3>
               <p>Total Class</p>
             </div>
             <div class="icon">
               <i class="fas fa-book-reader"></i>
             </div>
             <a href="{{ url('teacher/my_class_subject') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
           </div>
         </div>

         <div class="col-lg-3 col-6">
           <div class="small-box bg-warning">
             <div class="inner">
               <h3>{{ $totalSubject }}</h3>
               <p>Total Subject</p>
             </div>
             <div class="icon">
               <i class="fas fa-book-reader"></i>
             </div>
             <a href="{{ url('teacher/my_class_subject') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
             <a href="{{ url('teacher/my_notice_board') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
           </div>
         </div>



       </div>
     </div>
   </section>
 </div>
@endsection
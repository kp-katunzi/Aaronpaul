
@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('message') 
                    
                    <div class="card">
                        <div style="margin-top: 20px; ">
                            @if(!empty($user->getProfileDirect()))
                                <img src="{{ $user->getProfileDirect() }}" style="height:150px; width:120px; border-radius:6px; float:right; margin-right:40px">
                            @endif
                        </div>
                        <div class="card-body fs-3"> 
                        
                            <div><strong>Name:</strong> 
                                {{ $user->name }} {{ $user->middle_name }} {{ $user->last_name }}
                            </div>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Gender:</strong> {{ $user->gender }}</p>
                            <p><strong>Date of Birth:</strong> 
                                @if(!empty($user->date_of_birth))
                                    {{ date('d-m-Y', strtotime($user->date_of_birth)) }}
                                @else
                                    Not Available
                                @endif
                            </p>
                            <p><strong>Religion:</strong> {{ $user->religion }}</p>
                            <p><strong>Registration Number:</strong> {{ $user->admission_number }}</p>
                            <p><strong>Class Name:</strong> {{ $className ?? 'Not Available' }}</p>
                            <p><strong>Phone Number:</strong> {{ $user->phone_number }}</p>
                            <p><strong>Registration Date:</strong> 
                                @if(!empty($user->admission_date))
                                    {{ date('d-m-Y', strtotime($user->admission_date)) }}
                                @else
                                    Not Available
                                @endif
                            </p>
                            <p><strong>Blood Group:</strong> {{ $user->blood_group }}</p>
                            <p><strong>Form Four Registration NO:</strong> {{ $user->form_four_regno }}</p>
                            <p><strong>NIDA:</strong> {{ $user->nida }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

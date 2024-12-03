<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Login</title>
  @php
    $getHeaderSetting =  App\Models\SettingModel::getSingle();
  @endphp
  <link rel="icon" href="{{  $getHeaderSetting->getFaviconLogin() }}">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <link rel="stylesheet" href="{{ url('public/plugins/fontawesome-free/css/all.min.css')}}">

  <link rel="stylesheet" href="{{ url('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

  <link rel="stylesheet" href="{{ url('public/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-logo">
  <img src="{{ url('public/dist/img/ttc-rem.png')}}" style="width: 180px;" >
</div>

<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
    <div class="panel-title">
      College Management System (CMS)
    </div>
    </div>
    <div class="card-body">
      @include('message')

      <form action="{{ url('login') }}" method="post">
        {{csrf_field()}}
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" required placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" required  placeholder="Password">
          <p class="help-block help-block-error"></p>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
          
            
          <div class="form-group col-md-12">
            <button type="submit" class="btn btn-success btn-rounded btn-block full-width m-b"><i class="fas fa-sign-in-alt"></i>&nbsp;&nbsp;Login</button>                    
          </div>
        </div>
      </form>
       <p class="mb-1">
        <a href="{{ url('forgot-password')}}">Forgot password</a>
      </p>
    </div>
  </div>
</div>
<hr style="border: 1px solid #e6e6e6; border-color: #e6e6e6;">

  <div>
  <div class="text-center">
    Copyright &copy; {{ date('Y') }}. TTC CMS [Version 1.0]
  </div>

<script src="{{ url('public/plugins/jquery/jquery.min.js')}}"></script>

<script src="{{ url('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{ url('public/dist/js/adminlte.min.js')}}"></script>
</body>
</html>

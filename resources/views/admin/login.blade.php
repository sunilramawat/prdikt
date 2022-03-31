<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{URL('public/admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{URL('public/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{URL('public/admin/dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">

  <!-- Custom CSS File -->
  <link rel="stylesheet" href="{{URL('public/admin/docs/assets/css/custom.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card">
    <div class="card-body login-card-body">
      <div class="login-logo">
        <a href="">
<!--           <img src="{{URL('public/admin/dist/img/logo.svg')}}" alt=""> -->
        </a>
      </div>

      {!!Form::open(['url'=> route('doLogin'),'method'=>'post','id' => 'login_form' ])!!}

        <div class="login-title-box">
            <h4 class="login-title">Log In</h4>
        </div>
        
         @include('admin.alert_message')
        <div class="form-group input-group">
          <input type="email" name="email" id="email" placeholder="Enter Email Address" class="form-control">
          <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="form-group input-group">
          <label for="password" class="lableClass">Password</label>
          <input type="password" name="password" id="password" placeholder="Enter  Password" class="form-control">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-lg-12">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <span class="custom-checked">
                  <img src="{{URL('public/admin/dist/img/checked.svg')}}" alt="">
              </span>
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <div class="row">
          <div class="col-lg-4">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
          {{--<div class="col-lg-8">
            <p class="forgot-link">
              <a href="">Forgot Password?</a>
            </p>
          </div>--}}
          <!-- /.col -->
        </div>
      {!!Form::close()!!}
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{URL('public/admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{URL('public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{URL('public/admin/dist/js/adminlte.min.js')}}"></script>

<script type="text/javascript">
    $("#login_form").validate({

      rules: {
        email: {
          required: true,
        },
        password: {
          required: true,
        },
      },
      messages: {
        email: {
            required: "Please enter companydddd email address",
        },

        password: {
            required: "Please enter password",
        },
      },
    })

</script>

</body>
</html>

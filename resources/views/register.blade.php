<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FM | Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ app('url')->asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ app('url')->asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ app('url')->asset('bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ app('url')->asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ app('url')->asset('bower_components/admin-lte/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="{{ app('url')->asset('bower_components/admin-lte/dist/css/skins/skin-purple.min.css') }}">

  <link rel="stylesheet" href="{{ app('url')->asset('styles/main.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-purple register-page">
<div class="register-box">
  <div class="register-logo">
    File<b>Sharer</b>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>

    <form id='auth-register' action="{{ app('url')->to('auth/register') }}" method="post">
      <div class="form-group has-feedback">
        <label>Full name</label>
        <input name='fullname' type="text" class="form-control" placeholder="Full name" required>
      </div>
      <div class="form-group has-feedback">
        <label>Email</label>
        <input name='username' type="email" class="form-control" placeholder="Email" required>
      </div>
      <div class="form-group has-feedback">
        <label>Password</label>
        <input name='password' type="password" class="form-control" placeholder="Password" required>
      </div>
      <div class="form-group has-feedback">
        <label>Password confirmation</label>
        <input name='password_confirmation' type="password" class="form-control" placeholder="Confirm your password" required>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
      </div>
    </form>

    <a href="{{ app('url')->to('auth/login') }}" class="text-center">I already have a membership</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="{{ app('url')->asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery Forms -->
<script src="{{ app('url')->asset('bower_components/jquery-form/dist/jquery.form.min.js') }}"></script>
<!-- jQuery Validate -->
<script src="{{ app('url')->asset('bower_components/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ app('url')->asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ app('url')->asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ app('url')->asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ app('url')->asset('bower_components/admin-lte/dist/js/adminlte.min.js') }}"></script>

<script>
  $(function () {
    $('#auth-register').validate({
        rules : {
            password : {
                minlength : 5
            },
            password_confirmation : {
                minlength : 5,
                equalTo : '[name="password"]'
            }
        }
    });
  });
</script>

</body>
</html>
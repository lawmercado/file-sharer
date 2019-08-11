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
<body class="hold-transition skin-purple login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html">File<b>Sharer</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    @include('flash-messages')
    <p class="login-box-msg">Sign in to start your session</p>

    <form role="form" id="auth-login" action="{{ app('url')->to('auth/login') }}" method="POST">
      <div class="form-group has-feedback">
        <input name='username' class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input name='password' type="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        <button type="submit" class="btn btn-success btn-block btn-flat">Register a new membership</button>
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="{{ app('url')->asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery Forms -->
<script src="{{ app('url')->asset('bower_components/jquery-form/dist/jquery.form.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ app('url')->asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ app('url')->asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ app('url')->asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ app('url')->asset('bower_components/admin-lte/dist/js/adminlte.min.js') }}"></script>

@yield('flash-messages-scripts')

<script>
    $(function () {
        $("#auth-login").ajaxForm({
            success: function(response) {
                localStorage.setItem('token', response.token);

                window.location = "{{ app('url')->to('/') }}";
            },
            error: function(request) {
                fm.addMessage('danger', 'Invalid credentials.');

                window.location = "{{ app('url')->to('auth/login') }}";
            }
        });
    })
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/assets/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/admin/dist/css/adminlte.min.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

  @yield('css')

  <!-- Jquery 3.6 -->
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
</head>

<body class="hold-transition sidebar-mini">
  <!-- Wrapper -->
  <div class="wrapper">

    @include('admin.layouts.navbar')

    @include('admin.layouts.sidebar')

    <!-- Content -->
    @yield('content')
    <!-- End Content -->

  </div>
  <!-- End Wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
  <!-- /.control-sidebar -->

  @include('admin.layouts.footer')

  <!-- jQuery -->
  <script src="/assets/admin/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE -->
  <script src="/assets/admin/dist/js/adminlte.js"></script>
  <!-- Ajax Jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  @yield('script')

</body>

</html>
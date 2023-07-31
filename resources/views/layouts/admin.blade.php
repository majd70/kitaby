<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="{{App::currentLocale()}}" dir ="{{App::currentLocale()=='ar'? 'rtl':'ltr'}}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('/assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    @if(App::currentLocale()=='ar')
    <link rel="stylesheet" href="{{ asset('/assets/admin/css/adminlite.rtl.min.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('/assets/admin/css/adminlte.min.css') }}">
    @endif

    <style>


    .logout-link {
        margin-right: 2px;
        margin-top: 7px;
        font-size: 15px; /* Adjust font size as needed */
        color: #333;
        text-decoration: none;
        white-space: nowrap; /* Prevent line break for long link text */

    }
</style>






</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>


            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <!-- Notifications Dropdown Menu -->

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"
                        role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{ asset('assets/images/books.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"> كتابي</span>
            </a>


            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/profile-images/{{ $profile->image }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                    <a class="logout-link" href="{{ route('logout') }}">
                        <span>تسجيل الخروج</span>

                    </a>


                </div>
                <!-- SidebarSearch Form -->




                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                      <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                      <li class="nav-item menu-open">
                        <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                            لوحة التحكم
                            <i class="right fas fa-angle-left"></i>
                          </p>
                        </a>
                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <a href="{{route('categories.index')}}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>التصنيفات</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="{{route('groups.index')}}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>المجموعات</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="{{route('users.index')}}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>المستخدمون</p>
                            </a>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            @yield('title')
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                             @yield('breadcrumb')
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                @yield('content')

            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('/assets/adminplugins/jquery/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('/assets/admin/js/delete-notification.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('/assets/adminplugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/assets/admin/js/adminlte.min.js') }}"></script>

    <script src="{{ asset('/js/app.js') }}"></script>


    <script>

$(document).ready(function() {
    // Get the current URL
    var currentUrl = window.location.href;

    // Array of routes to highlight
    var routesToHighlight = [
      "http://localhost:8000/admin/groups",
      "http://localhost:8000/admin/categories",
      "http://localhost:8000/admin/users"
    ];

    // Check if the current URL matches any of the routes
    for (var i = 0; i < routesToHighlight.length; i++) {
      if (currentUrl.indexOf(routesToHighlight[i]) !== -1) {
        // Add 'active' class to the corresponding link
        $('a[href="' + routesToHighlight[i] + '"]').addClass('active');
        break; // Stop checking after finding a match
      }
    }
  });
      </script>

    @yield('js')


</body>

</html>

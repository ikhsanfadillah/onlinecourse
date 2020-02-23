<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>{{ config('app.name', 'Tatle Class') }} - @yield('title')</title>

  <!-- Font Awesome Icons -->
  <link href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <!-- Theme style -->
  <link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  {{-- TinyMCE WYSIWYG Editor --}}
  <script src="https://cdn.tiny.cloud/1/eqamb73skytggjqnzutuk6xvkxycl443pbkjiex8garfnhfp/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  @yield('style')
</head>
<body class="hold-transition sidebar-mini">
<div id="app" class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link py-0" data-toggle="dropdown" href="#">
          <div class="image">
            <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-1" alt="User Image" style="width: 2.5rem; height: auto;">
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
          <span class="dropdown-header text-capitalize">{{ Auth::user()->name }}</span>
          <div class="dropdown-divider"></div>
          <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt mr-2"></i> Log out

            <span class="float-right text-muted text-sm"> </span>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{ asset('img/Logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Tetler</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('adm/dashboard') ? 'active' : ''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <span class="right badge badge-danger d-none">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('setting.landingpage') }}" class="nav-link {{ request()->is('adm/setting') ? 'active' : ''}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Landing page
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('mentors.index') }}" class="nav-link {{ request()->is('adm/mentors') ? 'active' : ''}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Mentors
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('discounts.index') }}" class="nav-link {{ request()->is('adm/discounts') ? 'active' : ''}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Discount
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('faq.index') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Faq
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('news.index') }}" class="nav-link {{ request()->is('adm/news') ? 'active' : ''}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                News
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('support.index') }}" class="nav-link {{ request()->is('adm/support') ? 'active' : ''}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Support Desk
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('setting.index') }}" class="nav-link {{ request()->is('adm/setting') ? 'active' : ''}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Setting
              </p>
            </a>
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
            <h1 class="m-0 text-dark">@yield('subTitle')</h1>
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
      <div class="container-fluid">
        @yield('content')
        <!-- /.row -->
      </div><!-- /.container-fluid -->
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
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{ date('Y') }} <a href="https://gurusemua.com">gurusemua.com</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
@yield('script')

</body>
</html>

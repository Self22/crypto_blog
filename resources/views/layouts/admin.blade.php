<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Admin Template">
  <meta name="author" content="">
  <meta name="keyword" content="Bootstrap,Admin,Template">
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
  <title>Admin Template</title>

  <!-- Icons -->
  <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/simple-line-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
  <!-- Main styles for this application -->
  <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

  <!-- Styles required by this views -->
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

  <link href="{{ asset('css/summernote-bs4.css') }}" rel="stylesheet">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
  @include('layouts.partials.navbar')
  
  <div class="app-body">
    @include('layouts.partials.sidebar')
    <!-- Main content -->
    <main class="main">

      <!-- Breadcrumb -->
      @include('layouts.partials.breadcrumb')

      @yield('content')
      <!-- /.container-fluid -->
    </main>

    @include('layouts.partials.asidemenu')

  </div>

  @include('layouts.partials.footer')

  @include('layouts.partials.scripts')
  
  @yield('scripts')

</body>
</html>
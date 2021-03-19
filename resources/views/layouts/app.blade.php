<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@isset($title) {{ $title }} @endisset | {{ config('app.name') }} </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <script src="{{ config('blueadmin.fontawesomekit_url') }}" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('lteadmin/css/fonts.css')}}">
    <!-- Bootstrap 4 + Theme style -->
    <link rel="stylesheet" href="{{ asset('lteadmin/css/adminlte.css') }}">
    <!-- color-palettes -->
    <link rel="stylesheet" href="{{ asset('lteadmin/css/color-palettes.css')}}">
    <link rel="stylesheet" href="{{ asset('lteadmin/css/tail.datetime-default-blue.css')}}">
    <!-- Toaster -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @stack('blueadmin_header')
</head>

<body class="hold-transition sidebar-mini"  @if(config('blueadmin.test', false))style="border: 4px red solid;" @endif>
<div class="wrapper">
    <!-- navs -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <x-blueadmin-topbar-menu/>
        <ul class="navbar-nav ml-auto">
            @include('BlueAdminLayouts::partials.topbar.logout')
            <x-blueadmin-topbar-messages/>
            <x-blueadmin-topbar-notifications/>

            @include('BlueAdminLayouts::partials.sidebar.symbol')
        </ul>
    </nav>

    <x-blueadmin-leftmenu />


    <!-- /navs -->
    <section class="content">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper pl-3">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>{{ $title ?? 'Title not set' }}</h1>
                        </div>
                        @include('BlueAdminLayouts::partials.navigation.breadcrumbs')
                    </div>
                </div><!-- /.container-fluid -->

                @yield('main')

                {{ config('blueadmin.test') }}

            </section>

        </div>
        <!-- /.content-wrapper -->
    @include('BlueAdminLayouts::partials.footer.footer')
    @include('BlueAdminLayouts::partials.sidebar.aside')
</div><!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('lteadmin/vendor/jquery/jquery-3.4.1.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('lteadmin/vendor/bootstrap/js/bootstrap.bundle.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('lteadmin/js/adminlt.js')}}"></script>
<script src="{{asset('lteadmin/js/tail.datetime-full.js')}}"></script>
<script>
    tail.DateTime("#datetime");
</script>

@include('BlueAdminLayouts::partials.includes.toastr')
@stack('blueadmin_scripts')

</body>
</html>

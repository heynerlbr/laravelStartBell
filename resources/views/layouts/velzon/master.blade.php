<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | Campana</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico')}}">
    @include('layouts.velzon.head-css')
</head>

@section('body')
    @include('layouts.velzon.body')
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.velzon.topbar')
        @include('layouts.velzon.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.velzon.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    @include('layouts.velzon.customizer')

    <!-- JAVASCRIPT -->
    @include('layouts.velzon.vendor-scripts')
</body>

<script>
    document.getElementById("reloadButton").addEventListener("click", function() {
        // Agregar un parámetro aleatorio a la URL para evitar la caché
        const randomParam = Date.now(); // Puedes usar otro valor aleatorio si prefieres
        let urlOriginal = window.location.href;
        let url = window.location.href + "?nocache=" + randomParam;
        window.location.href = url;

        location.reload(true);

        window.location.href = urlOriginal;
        // location.reload(true);
    });
</script>

</html>

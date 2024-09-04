<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | GlOBAL MSI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{ asset('dastone-v2.0/HTML/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dastone-v2.0/HTML/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dastone-v2.0/HTML/assets/css/metisMenu.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dastone-v2.0/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('dastone-v2.0/HTML/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('dastone-v2.0/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('dastone-v2.0/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ asset('dastone-v2.0/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('dastone-v2.0/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('dastone-v2.0/plugins/leaflet/leaflet.css') }}" rel="stylesheet">
    <link href="{{ asset('dastone-v2.0/plugins/lightpick/lightpick.css') }}" rel="stylesheet" />
    <link href="{{ asset('dastone-v2.0/plugins/lightGallery/lightGallery.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css"
        integrity="sha512-yJHCxhu8pTR7P2UgXFrHvLMniOAL5ET1f5Cj+/dzl+JIlGTh5Cz+IeklcXzMavKvXP8vXqKMQyZjscjf3ZDfGA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />



    <style>
        .close {
            background-color: white !important;
            color: white !important;
        }

        .select2 {
            width: 100% !important;
        }

        .select2-selection.select2-container {
            height: 33px !important;
        }

        .select2-container{
            border: 1px solid #e3ebf6 !important;
        }
        .select2-container > span{
            border: transparent !important;
        }
        .select2-container--default .select2-selection--single {
            border-radius:0px !important;
            border: 1px solid #e3ebf6;
        }

        .nav-link {
            cursor: pointer;
        }

        .btn-secondary {
            color: black !important;
            background-color: transparent !important;
            border-color: black !important;
        }

        

        @media screen and (max-width: 1132px) {
            #form_create_repuesto {
                display: none
            }
        }

        @media screen and (min-width: 1133px) {
            #form_create_repuesto {
                display: contents
            }
        }
    </style>
    @yield('css')

</head>

<body class="dark-sidenav">
    <!-- Left Sidenav -->
    <div class="left-sidenav">
        <!-- LOGO -->
        <div class="brand">
            <a href="index.html" class="logo">
                <span>
                    <!-- <img src="{{ asset('dastone-v2.0/HTML/assets/images/logo-sm.png') }}" alt="logo-small" class="logo-sm"> -->
                    <img src="{{ asset('imgnavlogo.png') }}" alt="logo-small" class="logo-sm"
                        style="height: 100px !important;
                        width: 60% !important;">
                </span>
                <span>
                    <!-- <img src="{{ asset('dastone-v2.0/HTML/assets/images/logo.png') }}" alt="logo-large" class="logo-lg logo-light">
                        <img src="{{ asset('dastone-v2.0/HTML/assets/images/logo-dark.png') }}" alt="logo-large" class="logo-lg logo-dark"> -->
                </span>
            </a>
        </div>
        <!--end logo-->
        <div class="menu-content h-100" data-simplebar>
            <ul class="metismenu left-sidenav-menu">
                {{-- <li class="menu-label mt-0">SOFTWARE MANTENIMIENTO </li> --}}
                <li class="menu-label mt-0">&nbsp; </li>
                {{-- @if (Auth::user()->roles()->get()[0]['pivot']['role_id'] == '1') --}}
                <li class="nav-item"><a class="nav-link" href="dashboard"><i class="fas fa-home"></i>Dashboard</a></li>
                {{-- @endif --}}
                <li class="nav-item"><a class="nav-link" href="ordenes"><i class="fas fa-list"></i>Cotizaciones</a></li>
                <li class="nav-item"><a class="nav-link" href="subastasproveedores"><i
                            class="fa fa-gavel align-self-center menu-icon"></i>Subastas</a></li>
                @if (Auth::user()->roles()->get()[0]['pivot']['role_id'] == '1')
                    <li>
                        <a href="javascript: void(0);"><i class="fa fa-users align-self-center menu-icon"></i> Usuarios
                            <span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>

                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="nav-item"><a class="nav-link" href="usuarios"><i
                                        class="ti-control-record"></i>Usuarios</a></li>
                            <li class="nav-item"><a class="nav-link" href="roles"><i
                                        class="ti-control-record"></i>Roles</a></li>



                        </ul>
                    </li>

                    {{-- <li class="nav-item"><a class="nav-link" href="subastas"><i class="fa fa-gavel align-self-center menu-icon"></i>Subastas</a></li> --}}
                    
                    <li>
                        <a href="javascript: void(0);"><i class="fas fa-cogs align-self-center menu-icon"></i>
                            Parametros <span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>

                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="nav-item"><a class="nav-link" href="categorias"><i
                                class="ti-control-record"></i>Categorias</a></li>
                            <li class="nav-item"><a class="nav-link" href="sucursales"><i
                                class="ti-control-record"></i>Sucursales</a></li>
                            <li class="nav-item"><a class="nav-link" href="marcas"><i
                                class="ti-control-record"></i>Marcas</a></li>    
                        </ul>
                    </li>

                @endif
                <li class="nav-item"><a class="nav-link" href="repuestos"><i class="fas fa-hammer"></i>Mis
                        Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="empresas"><i class="fas fa-building"></i>Mis
                        Empresas</a></li>
                <li class="nav-item"><a class="nav-link" href="empresassistemas"><i class="fas fa-building"></i>
                    Empresas Sistema</a></li>
                <li class="nav-item"><a class="nav-link" href="hojasvidas"><i class="fas fa-file"></i>
                Hojas Vida</a></li>
                <li class="nav-item"><a class="nav-link" href="preoperacionales"><i class="fas fa-file"></i>
                Preoperacionales</a></li>    
                <li class="nav-item"><a class="nav-link" href="capacitaciones"><i class="fas fa-file"></i>
                    Capacitaciones</a></li>



            </ul>
        </div>
    </div>
    <!-- end left-sidenav-->


    <div class="page-wrapper">
        <!-- Top Bar Start -->
        <div class="topbar">
            <!-- Navbar -->
            <nav class="navbar-custom">
                <ul class="list-unstyled topbar-nav float-end mb-0">
                    {{-- <li class="dropdown hide-phone">
                            <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-bs-toggle="dropdown" href="#" role="button"
                                aria-haspopup="false" aria-expanded="false">
                                <i data-feather="search" class="topbar-icon"></i>
                            </a>
                            
                            <div class="dropdown-menu dropdown-menu-end dropdown-lg p-0">
                                <!-- Top Search Bar -->
                                <div class="app-search-topbar">
                                    <form action="#" method="get">
                                        <input type="search" name="search" class="from-control top-search mb-0" placeholder="Type text...">
                                        <button type="submit"><i class="ti-search"></i></button>
                                    </form>
                                </div>
                            </div>
                        </li>                       --}}
                    {{-- 
                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-bs-toggle="dropdown" href="#" role="button"
                                aria-haspopup="false" aria-expanded="false">
                                <i data-feather="bell" class="align-self-center topbar-icon"></i>
                                <span class="badge bg-danger rounded-pill noti-icon-badge">2</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0">
                            
                                <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                                    Notifications <span class="badge bg-primary rounded-pill">2</span>
                                </h6> 
                                <div class="notification-menu" data-simplebar>
                                    <!-- item-->
                                    <a href="#" class="dropdown-item py-3">
                                        <small class="float-end text-muted ps-2">2 min ago</small>
                                        <div class="media">
                                            <div class="avatar-md bg-soft-primary">
                                                <i data-feather="shopping-cart" class="align-self-center icon-xs"></i>
                                            </div>
                                            <div class="media-body align-self-center ms-2 text-truncate">
                                                <h6 class="my-0 fw-normal text-dark">Your order is placed</h6>
                                                <small class="text-muted mb-0">Dummy text of the printing and industry.</small>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </a><!--end-item-->
                                    <!-- item-->
                                    <a href="#" class="dropdown-item py-3">
                                        <small class="float-end text-muted ps-2">10 min ago</small>
                                        <div class="media">
                                            <div class="avatar-md bg-soft-primary">
                                                <img src="assets/images/users/user-4.jpg" alt="" class="thumb-sm rounded-circle">
                                            </div>
                                            <div class="media-body align-self-center ms-2 text-truncate">
                                                <h6 class="my-0 fw-normal text-dark">Meeting with designers</h6>
                                                <small class="text-muted mb-0">It is a long established fact that a reader.</small>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </a><!--end-item-->
                                    <!-- item-->
                                    <a href="#" class="dropdown-item py-3">
                                        <small class="float-end text-muted ps-2">40 min ago</small>
                                        <div class="media">
                                            <div class="avatar-md bg-soft-primary">                                                    
                                                <i data-feather="users" class="align-self-center icon-xs"></i>
                                            </div>
                                            <div class="media-body align-self-center ms-2 text-truncate">
                                                <h6 class="my-0 fw-normal text-dark">UX 3 Task complete.</h6>
                                                <small class="text-muted mb-0">Dummy text of the printing.</small>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </a><!--end-item-->
                                    <!-- item-->
                                    <a href="#" class="dropdown-item py-3">
                                        <small class="float-end text-muted ps-2">1 hr ago</small>
                                        <div class="media">
                                            <div class="avatar-md bg-soft-primary">
                                                <img src="assets/images/users/user-5.jpg" alt="" class="thumb-sm rounded-circle">
                                            </div>
                                            <div class="media-body align-self-center ms-2 text-truncate">
                                                <h6 class="my-0 fw-normal text-dark">Your order is placed</h6>
                                                <small class="text-muted mb-0">It is a long established fact that a reader.</small>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </a><!--end-item-->
                                    <!-- item-->
                                    <a href="#" class="dropdown-item py-3">
                                        <small class="float-end text-muted ps-2">2 hrs ago</small>
                                        <div class="media">
                                            <div class="avatar-md bg-soft-primary">
                                                <i data-feather="check-circle" class="align-self-center icon-xs"></i>
                                            </div>
                                            <div class="media-body align-self-center ms-2 text-truncate">
                                                <h6 class="my-0 fw-normal text-dark">Payment Successfull</h6>
                                                <small class="text-muted mb-0">Dummy text of the printing.</small>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </a><!--end-item-->
                                </div>
                                <!-- All-->
                                <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                                    View all <i class="fi-arrow-right"></i>
                                </a>
                            </div>
                        </li> --}}

                    <li class="dropdown">
                        {{-- <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-bs-toggle="dropdown" href="#" role="button"
                                aria-haspopup="false" aria-expanded="false">
                                <span class="ms-1 nav-user-name hidden-sm">Nick</span>
                                <img src="assets/images/users/user-5.jpg" alt="profile-user" class="rounded-circle thumb-xs" />                                 
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#"><i data-feather="user" class="align-self-center icon-xs icon-dual me-1"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i data-feather="settings" class="align-self-center icon-xs icon-dual me-1"></i> Settings</a>
                                <div class="dropdown-divider mb-0"></div>
                                <a class="dropdown-item" href="#"><i data-feather="power" class="align-self-center icon-xs icon-dual me-1"></i> Logout</a>
                            </div> --}}
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user"
                                data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                                aria-expanded="false">
                                <span class="ms-1 nav-user-name hidden-sm">{{ Auth::user()->name }}</span>
                                <img src="{{ asset('dastone-v2.0/HTML/assets/images/users/user-5.jpg') }}"
                                    alt="profile-user" class="rounded-circle thumb-xs" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="dropdown-divider mb-0"></div>
                                <a class="dropdown-item" href="{{ route('perfil') }}"><i data-feather="settings"
                                        class="align-self-center icon-xs icon-dual me-1"></i> Perfil</a>
                                <div class="dropdown-divider mb-0"></div>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"><i
                                        data-feather="power" class="align-self-center icon-xs icon-dual me-1"></i> Cerrar
                                    Sesión</a>



                            </div>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endguest
                    </li>
                </ul>
                <!--end topbar-nav-->

                <ul class="list-unstyled topbar-nav mb-0">
                    <li>
                        <button class="nav-link button-menu-mobile">
                            <i data-feather="menu" class="align-self-center topbar-icon"></i>
                        </button>
                    </li>
                    {{-- <li class="creat-btn">
                            <div class="nav-link">
                                <a class=" btn btn-sm btn-soft-primary" href="#" role="button"><i class="fas fa-plus me-2"></i>New Task</a>
                            </div>                                
                        </li>                            --}}
                </ul>
            </nav>
            <!-- end navbar-->
        </div>
        <!-- Top Bar End -->

        <!-- Page Content-->
        <div class="page-content">
            <div class="container-fluid">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <div class="row">
                                <div class="col">
                                    <h4 class="page-title"> @yield('content_header')</h4>
                                    {{-- <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dastone</a></li>
                                            <li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
                                            <li class="breadcrumb-item active">Starer</li>
                                        </ol> --}}
                                </div>
                                <!--end col-->
                                <div class="col-auto align-self-center">
                                    <a href="#" class="btn btn-sm btn-outline-primary" id="Dash_Date">
                                        <span class="day-name" id="Day_Name">Today:</span>&nbsp;
                                        <span class="" id="Select_date">Jan 11</span>
                                        <i data-feather="calendar" class="align-self-center icon-xs ms-1"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i data-feather="download" class="align-self-center icon-xs"></i>
                                    </a>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end page-title-box-->
                        @yield('content')
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
                <!-- end page title end breadcrumb -->


            </div><!-- container -->

            <footer class="footer text-center text-sm-start">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script> Sodeker <span
                    class="text-muted d-none d-sm-inline-block float-end">Desarrollado <i
                        class="mdi mdi-heart text-danger"></i> por Sodeker</span>
            </footer>
            <!--end footer-->
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->



    <!-- jQuery  -->
    <script src="{{ asset('dastone-v2.0/HTML/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/HTML/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/HTML/assets/js/metismenu.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/HTML/assets/js/waves.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/HTML/assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/HTML/assets/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/HTML/assets/js/moment.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Required datatable js -->
    <script src="{{ asset('dastone-v2.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('dastone-v2.0/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/plugins/datatables/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/plugins/datatables/buttons.colVis.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ asset('dastone-v2.0/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/HTML/assets/pages/jquery.datatable.init.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/plugins/tippy/tippy.all.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('dastone-v2.0/HTML/assets/js/app.js') }}"></script>
    <script src="{{ asset('js/vue.min.js') }}"></script>
    {{-- <script src="{{asset('js/vue.min.js')}}"></script> --}}
    <script src="{{ asset('js/jquery.masknumber.js') }}"></script>

    {{-- <script src="{{asset('dastone-v2.0/plugins/leaflet/leaflet.js')}}"></script>  --}}
    <script src="{{ asset('dastone-v2.0/plugins/lightpick/lightpick.js') }}"></script>
    {{-- <script src="{{asset('dastone-v2.0/HTML/assets/pages/jquery.profile.init.js')}}"></script>  --}}






    <script src="{{ asset('dastone-v2.0/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>

    <script src="{{ asset('dastone-v2.0/plugins/lightGallery/lightgallery-all.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js"
        integrity="sha512-Gfrxsz93rxFuB7KSYlln3wFqBaXUc1jtt3dGCp+2jTb563qYvnUBM/GP2ZUtRC27STN/zUamFtVFAIsRFoT6/w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>



    {{-- <script src="assets/pages/jquery.analytics_dashboard.init.js"></script> --}}


    {{-- <script src="assets/js/app.js"></script> --}}

    @yield('js')

    <!-- App js -->


</body>

</html>

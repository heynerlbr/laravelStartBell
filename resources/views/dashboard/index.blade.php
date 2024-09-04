@extends('layouts.velzon.master')
@section('title', 'Dashboard')
@section('content_header')
    Dashboard
@stop
@section('content')
    <div id="app">
        <div class="row" style="display: none">
            <div class="col-md-4">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                    Contratos</p>
                            </div>
                            <div class="flex-shrink-0">
                                <h5 class="text-success fs-14 mb-0">
                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                    +100 %
                                </h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                        data-target="559.25" v-text="conteoContratos">559.25</span>
                                </h4>
                                {{-- <a href="" class="text-decoration-underline">View net
                                    earnings</a> --}}
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-success-subtle rounded fs-3">
                                    <i class="bx  bx-file text-success"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                    Usuarios</p>
                            </div>
                            <div class="flex-shrink-0">
                                <h5 class="text-success fs-14 mb-0">
                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                    +100 %
                                </h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                        data-target="183.35" v-text="conteoUser">183.35</span>
                                </h4>
                                {{-- <a href="" class="text-decoration-underline">See details</a> --}}
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-warning-subtle rounded fs-3">
                                    <i class="bx bx-user-circle text-warning"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                    Clientes</p>
                            </div>
                            <div class="flex-shrink-0">
                                <h5 class="text-success fs-14 mb-0">
                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                    +100 %
                                </h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                        data-target="183.35" v-text="conteoTerceros">183.35</span>
                                </h4>
                                {{-- <a href="" class="text-decoration-underline">See details</a> --}}
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-success-subtle rounded fs-3">
                                    <i class="bx bx-user-check text-success"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div>
        </div>


        @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('Adminstrador') || Auth::user()->hasRole('superadministrador') || Auth::user()->hasRole('observador'))
            <div class="row" id="dash_b">
                <div class="col">
                    <div class="h-100">
                        <div class="row mb-3 pb-1">
                            <div class="col-12">
                                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                    <div class="flex-grow-1 card" style="padding: 1em;">
                                        <h4 class="fs-16 mb-1">Buen día,</h4>                                  
                                        <p class="text-muted mb-0">Estamos encantados de darte la bienvenida a StarBell.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        @endif
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.2.19/css/lightgallery.min.css" />
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('Slicebox-master/css/demo.css')}}" /> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('Slicebox-master/css/slicebox.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('Slicebox-master/css/custom.css') }}" />
    <script type="text/javascript" src="{{ asset('Slicebox-master/js/modernizr.custom.46884.js') }}"></script>
    <style>
        .swal2-confirm {
            margin-right: 10px;
            /* Agrega un margen a la derecha del botón "No" */
            font-size: 1.5em;
        }
        .swal2-cancel {
            margin-right: 10px;
            /* Estilos personalizados para el botón "Si" (opcional) */
            font-size: 1.5em;
        }
    </style>
@stop
@section('js')
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.js"
        integrity="sha512-otOZr2EcknK9a5aa3BbMR9XOjYKtxxscwyRHN6zmdXuRfJ5uApkHB7cz1laWk2g8RKLzV9qv/fl3RPwfCuoxHQ=="
        crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('dastone-v2.0/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('dastone-v2.0/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" defer></script> -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="/js/global.js"></script>
    <script src="/js/dashboard/dashboard.js?v=<?php echo date('YmdHis'); ?>"></script>
    <script type="text/javascript" src="{{ asset('Slicebox-master/js/jquery.slicebox.js') }}"></script>
    <script>
        $('#redirectToPreoperacionales').on('click', function() {
            // Redirigir a la URL "preoperacionales"
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger",
                },
                buttonsStyling: false,
            });
            swalWithBootstrapButtons
                .fire({
                    title: "Información",
                    text: "¿Está seguro de que desea crear un  preoperacional?",
                    icon: "warning",
                    showCancelButton: true,
                    showCloseButton: true,
                    confirmButtonText: "Si",
                    cancelButtonText: "No",
                    reverseButtons: true,
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/preoperacional';
                    }
                });
        });
        $('#redirectToCapacitaciones').on('click', function() {
            // Redirigir a la URL "preoperacionales"
            window.location.href = '/capacitaciones';
        });
        $('#redirectToFacturas').on('click', function() {
            // Redirigir a la URL "preoperacionales"
            window.location.href = '/facturas';
        });
    </script>
@stop

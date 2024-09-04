@extends('layouts.velzon.master')
@section('title', 'Dashboard')
@section('content_header')
    Dashboard
@stop
@section('content')

    <div>
        <div class="row ">
            @if(!Auth::user()->hasRole('mantenimiento'))           
            <div class="col-12 " id="redirectToPreoperacionales" >             
                    <div class="card">
                        <div class="card-body text-center py-4">
                            <lord-icon src="https://cdn.lordicon.com/oclwxpmm.json" trigger="hover" colors="primary:#405189" target="div" style="width:50px;height:50px"></lord-icon>
                            <a href="#!" class="stretched-link">
                                <h3 class="mt-4">Preoperacional</h3>
                            </a>
                            <p class="text-muted mb-0"></p>
                        </div>
                    </div>               
            </div>
            <div class="col-12 " id="redirectToCapacitaciones">
               
                <div class="card">
                    <div class="card-body text-center py-4">
                     
                        <lord-icon src="https://cdn.lordicon.com/dklbhvrt.json" trigger="hover" colors="primary:#405189" target="div" style="width:50px;height:50px"></lord-icon>
                        <a href="#!" class="stretched-link">
                            <h3 class="mt-4">Capacitación</h3>
                        </a>
                        <p class="text-muted mb-0"></p>
                    </div>
                </div>
                
            </div>
            @endif
            <div class="col-12 " id="redirectToFacturas">
                
               
                <div class="card" >
                    <div class="card-body text-center py-4">
                        <lord-icon src="https://cdn.lordicon.com/sygggnra.json" trigger="hover" colors="primary:#405189" target="div" style="width:50px;height:50px"></lord-icon>
                        <a  class="stretched-link">
                            <h3 class="mt-4">Mantenimiento</h3>
                        </a>
                        <p class="text-muted mb-0"></p>
                    </div>
                </div>
              
            </div>
            @if(!Auth::user()->hasRole('mantenimiento'))
            <div class="col-12 " id="redirectToInformacion">
                
               
                <div class="card" >
                    <div class="card-body text-center py-4">
                        {{-- <img src="imagenes/document.gif" trigger="hover" colors="primary:#405189" target="div" style="width:50px;height:50px">
                         --}}
                         <lord-icon src="https://cdn.lordicon.com/pvbjsfif.json" trigger="hover" colors="primary:#405189" target="div" style="width:50px;height:50px"></lord-icon>

                        <a  class="stretched-link">
                            <h3 class="mt-4">Información</h3>
                        </a>
                        <p class="text-muted mb-0"></p>
                    </div>
                </div>
              
            </div>
            @endif
            
        </div>
    </div>
   
            



       

    @stop
    @section('css')

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
            integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />


        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.2.19/css/lightgallery.min.css" />




        {{-- <link rel="stylesheet" type="text/css" href="{{asset('Slicebox-master/css/demo.css')}}" /> --}}
		<link rel="stylesheet" type="text/css" href="{{asset('Slicebox-master/css/slicebox.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('Slicebox-master/css/custom.css')}}" />
		<script type="text/javascript" src="{{asset('Slicebox-master/js/modernizr.custom.46884.js')}}"></script>

        {{-- <style>
            .swal2-confirm {
                margin-right: 10px; /* Agrega un margen a la derecha del botón "No" */

                font-size:1.5em; 
            }

            .swal2-cancel {
                margin-right: 10px;  /* Estilos personalizados para el botón "Si" (opcional) */
                font-size:1.5em; 
            }
        </style> --}}



    @stop
    @section('js')
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"  ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.js"


                integrity="sha512-otOZr2EcknK9a5aa3BbMR9XOjYKtxxscwyRHN6zmdXuRfJ5uApkHB7cz1laWk2g8RKLzV9qv/fl3RPwfCuoxHQ=="
                crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('dastone-v2.0/plugins/apex-charts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('dastone-v2.0/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
        <script src="{{ asset('dastone-v2.0/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
        <!-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" defer></script> -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="/js/global.js"></script>
        <script src="/js/dashboard/dashboard.js?v=<?php echo date('YmdHis'); ?>"></script>
        <script type="text/javascript" src="{{asset('Slicebox-master/js/jquery.slicebox.js')}}"></script>
       


      

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
              window.location.href = '/capacitacion';
            });
            $('#redirectToFacturas').on('click', function() {
            // Redirigir a la URL "preoperacionales"
              window.location.href = '/factura';
            });

            $('#redirectToInformacion').on('click', function() {
            // Redirigir a la URL "preoperacionales"
              window.location.href = '/informacion';
            });

            
        </script>
    @stop

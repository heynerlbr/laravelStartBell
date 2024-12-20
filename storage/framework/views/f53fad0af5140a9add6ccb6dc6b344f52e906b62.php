
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content_header'); ?>
    Dashboard
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
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
                       
                    </div><!-- end card body -->
                </div>
            </div>
        </div>

       
        <?php if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('Adminstrador') || Auth::user()->hasRole('superadministrador') || Auth::user()->hasRole('observador')): ?>
            <div class="row" id="dash_b">
                <div class="col">
                    <div class="h-100">
                        <div class="row mb-3 pb-1">
                            <div class="col-10">
                                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                    <div class="flex-grow-1 card" style="padding: 1em;">
                                        <h4 class="fs-16 mb-1">Buen día,</h4>                                  
                                        <p class="text-muted mb-0">Estamos encantados de darte la bienvenida a StarBell.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                <div class="flex-grow-1 card" style="padding: 1em;">
                                    <a href="/generar-qr" target="_blank" rel="noopener noreferrer" class="btn btn-success">Generar QR</a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-6 mb-3 card">
                <comp-grafica-reservas></comp-grafica-reservas>
            </div>
            <div class="col-6  mb-3 card">
                <comp-grafica-lineas></comp-grafica-lineas>
            </div>
            <div class="col-6  mb-3 card">
                <comp-grafica-radar></comp-grafica-radar>
            </div>
            <div class="col-6  mb-3 card">
                <comp-grafica-polar></comp-grafica-polar>
            </div>
            <div class="col-6  mb-3 card">
                <comp-grafica-donut></comp-grafica-donut>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('Slicebox-master/css/slicebox.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('Slicebox-master/css/custom.css')); ?>" />
    <script type="text/javascript" src="<?php echo e(asset('Slicebox-master/js/modernizr.custom.46884.js')); ?>"></script>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(URL::asset('build/libs/prismjs/prism.js')); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.js"
        integrity="sha512-otOZr2EcknK9a5aa3BbMR9XOjYKtxxscwyRHN6zmdXuRfJ5uApkHB7cz1laWk2g8RKLzV9qv/fl3RPwfCuoxHQ=="
        crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo e(asset('dastone-v2.0/plugins/apex-charts/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('dastone-v2.0/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('dastone-v2.0/plugins/jvectormap/jquery-jvectormap-us-aea-en.js')); ?>"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" defer></script> -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="/js/dashboard/components/comp-reservas.js"></script>
    <script src="/js/dashboard/components/comp-grafica-donut.js"></script>
    <script src="/js/dashboard/components/comp-grafica-lineas.js"></script>
    <script src="/js/dashboard/components/comp-grafica-polar.js"></script>
    <script src="/js/dashboard/components/comp-grafica-radar.js"></script>
    <script src="/js/global.js"></script>
    <script src="/js/dashboard/dashboard.js?v=<?php echo date('YmdHis'); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('Slicebox-master/js/jquery.slicebox.js')); ?>"></script>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.velzon.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\LaravelStarbell\resources\views/dashboard/index.blade.php ENDPATH**/ ?>
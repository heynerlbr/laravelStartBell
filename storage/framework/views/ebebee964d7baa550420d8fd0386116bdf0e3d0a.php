<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?php echo e(URL::asset('build/images/logo-sm.png')); ?>" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(URL::asset('build/images/logo-dark.png')); ?>" alt="" height="17">
                        </span>
                    </a>
                    <a href="index" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?php echo e(URL::asset('build/images/logo-sm.png')); ?>" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(URL::asset('build/images/logo-light.png')); ?>" alt="" height="17">
                        </span>
                    </a>
                </div>
                <?php if(!Auth::user()->hasRole('conductor')): ?>
                    <button type="button"
                        class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none"
                        id="topnav-hamburger-icon">
                        <span class="hamburger-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                <?php endif; ?>
                
                    <?php
                        $user = Auth::user();
                        $empresaImg = $user->empresa ? $user->empresa->img : null;
                    ?>
                    
                
                <!-- App Search-->
                
            </div>
            <div class="d-flex align-items-center">
                
                
                
                
                <?php if(Auth::user()->hasRole('superadministrador') || Auth::user()->hasRole('Adminstrador')): ?>
                    <!-- ////////////// Reportes //////////////// -->
                    <div class="ms-1 header-item  d-sm-flex">
                        <button class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <i class='ri-file-list-fill fs-22'></i>
                        </button>    
                    </div>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                        <div class="offcanvas-header">
                            <h5 id="offcanvasRightLabel">Reportes</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label class="form-label" for="">Tipo</label>
                                    <select name="" id="Tipo" class="accion form-control select">
                                        <option value="0">Seleccione...</option>
                                        <!-- <option value="1">Kilometraje Total</option> -->
                                        <!-- <option value="2">Mantenimientos Realizados</option> -->
                                        <option value="3">Cantidad Vehiculos</option>
                                        <option value="4">Cantidad Preoperacionales</option>
                                        <!-- <option value="5">Vehiculos con hallazgos</option> -->
                                        <!-- <option value="6">Infracciones</option> -->
                                        <option value="7">PreoperacionalesUnoUno</option>
                                        <option value="8">Cantidad Conductores</option>
                                        <?php if(Auth::user()->id == 5): ?>
                                        <option value="9">Todos los preoperacionales</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="">Planta</label>
                                    <select name="" id="Planta" class="accion form-control select">
                                        <option value="0">Seleccione...</option>
                                        <?php if(Auth::user()->id == 5): ?>
                                        <option value="99">Todas</option>
                                        <?php endif; ?>
                                        <option value="2">Giron 1</option>
                                        <option value="3">Giron 2</option>
                                        <option value="4">Cúcuta</option>
                                        <option value="9">Villavicencio</option>
                                        <option value="11">Funza</option>
                                        <option value="12">Direccion General</option>
                                        <option value="13">Ibague</option>
                                        <option value="14">Palermo</option>
                                        <option value="15">Cosechas</option>
                                        <option value="16">Premezclas</option>
                                        <option value="17">Neg. Huevos</option>
                                        <option value="19">Barranquilla</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="fechaInicio">Fecha Inicio</label>
                                    <input type="text" class="form-control flatpickr-input accion" id="fechaInicio" placeholder="Fecha Inicio" data-provider="flatpickr">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="fechaFin">Fecha Fin</label>
                                    <input type="text" class="form-control flatpickr-input accion" id="fechaFin" placeholder="Fecha Fin" data-provider="flatpickr">
                                </div>
                                <div class="list-grid-nav hstack gap-1">
                                    <a class="btn btn-success btn-sm" id="generarPdfBtn">
                                        <i class="ri-file-pdf-fill label-icon align-middle fs-16 me-2"></i> Excel
                                    </a>
                                </div>
                                <script>
                                    document.getElementById('generarPdfBtn').addEventListener('click', function () {
                                        var fechaInicio = document.getElementById('fechaInicio').value;
                                        var fechaFin = document.getElementById('fechaFin').value;
                                        var Tipo = document.getElementById('Tipo').value;
                                        var Planta = document.getElementById('Planta').value;
                                        console.log(Tipo);
                                        var registroId = "tu_valor_aqui";  // Reemplaza "tu_valor_aqui" con la lógica para obtener el ID de tu registro
                                        if (fechaInicio === "") {
                                            fechaInicio = 1
                                        }
                                        if ( fechaFin === "") {
                                            fechaFin = 1
                                        }
                                        var pdfUrl = 'Prueba/' + fechaInicio + '/' + fechaFin+ '/' + Tipo+ '/' + Planta;
                                        window.open(pdfUrl, '_blank');
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <!-- ////////////////////////////// --> 
                <?php endif; ?>
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none"
                        data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>
                
                <div class="ms-1 header-item  d-sm-flex">
                    <a href="https://web.whatsapp.com/send?phone=313 2163045" target="_blank" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle">
                        <i class='bx bx-support fs-22 text-success'></i>
                    </a>
                </div>
                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-update fs-22"></i>
                        <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg p-0 dropdown-menu-end" style="">
                        <div class="p-2">
                            <div class="text-center">
                                <div class="avatar-md mx-auto my-3">
                                    <div class="avatar-title bg-soft-info text-info fs-36 rounded-circle">
                                        <i class="mdi mdi-update"></i>
                                    </div>
                                </div>
                                <h5 class="mb-2">Nueva actualización disponible!</h5>
                                <div class="mb-3 p-2"><span>Se requiere una actualización para acceder a las últimas mejoras y correcciones.</span></div>
                                <a href="#!" class="btn btn-success w-md mb-3" id="reloadButton">Actualizar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            
                                <img class="rounded-circle header-profile-user"
                                src="<?php if(Auth::user()->imgUser != ''): ?> <?php echo e(Auth::user()->imgUser); ?><?php else: ?><?php echo e(asset('imagenes/avatar.png')); ?> <?php endif; ?>"
                                alt="Header Avatar">                                
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo e(Auth::user()->name); ?></span>
                                
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Bienvenido <?php echo e(Auth::user()->name); ?>!</h6>
                        <a class="dropdown-item" href="perfil"><i
                                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Perfil</span></a>
                        
                        
                        <?php if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('Adminstrador') || Auth::user()->hasRole('superadministrador')): ?>
                        <a class="dropdown-item" href="basicos">
                            <span class="badge bg-success-subtle text-success mt-1 float-end">New</span>
                            <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Empresa</span>
                        </a>
                        <a class="dropdown-item" href="usuarios"><i
                            class="mdi mdi-account-group text-muted fs-16 align-middle me-1"></i> <span
                            class="align-middle">Usuarios</span></a>
                        <div class="dropdown-divider"></div>
                        <?php endif; ?>
                        
                        
                        <a class="dropdown-item " href="javascript:void();"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bx bx-power-off font-size-16 align-middle me-1"></i> <span
                                key="t-logout"><?php echo app('translator')->get('Cerrar Sesión'); ?></span>
                        </a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete
                        It!</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $__env->startSection('js'); ?>
<script src="/js/marcas/marcas.js?v=<?php echo date('YmdHis'); ?>"></script>
<?php $__env->stopSection(); ?><?php /**PATH C:\wamp64\www\LaravelStarbell\resources\views/layouts/velzon/topbar.blade.php ENDPATH**/ ?>
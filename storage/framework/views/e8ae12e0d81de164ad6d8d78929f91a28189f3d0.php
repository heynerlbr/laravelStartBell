<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu" style="--vz-vertical-menu-bg: #003f70 !important;">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="dashboard" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('storage/Msi-Logo blanco.png')); ?>" alt="" height="100">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('storage/Msi-Logo blanco.png')); ?>" alt="" height="100">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="dashboard" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('storage/Msi-Logo blanco.png')); ?>" alt="" height="50">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('storage/Msi-Logo blanco.png')); ?>" alt="" height="90">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                

                

                    <li class="menu-label mt-0">&nbsp; </li>
                
    
                    
                    

                    <!-- <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarHojas" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarHojas">
                            <i class="mdi mdi-car-cog"></i> <span>Preoperacional
                            </span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarHojas">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item"><a href="dashboard" class="nav-link menu-link">Dashboard</a></li>
                                <li class="nav-item"><a href="hojasvidas" class="nav-link menu-link">Hojas Vida</a></li>
                                <li class="nav-item"><a class="nav-link " href="preoperacionales menu-link">Preoperacionales</a></li>    
                                <li class="nav-item"><a class="nav-link " href="capacitaciones menu-link">Capacitaciones</a></li>

                            </ul>
                        </div>
                    </li>  -->

                    <!-- <li class="nav-item">
                        <a class="nav-link menu-link collapsed" href="dashboard" >Dashboard</a>
                    </li> -->
                    <?php if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('Adminstrador') || Auth::user()->hasRole('superadministrador') || Auth::user()->hasRole('Observador')): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link " href="home">
                            <i class="mdi mdi-desktop-mac-dashboard"></i> <span data-key="t-widgets">Dashboard</span>
                        </a>
                    </li>

                    

                   
                
                   
                    <li class="menu-title"><i class="ri-more-fill" aria-expanded="false"></i> <span data-key="t-components">Parametros</span></li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link menu-link " href="lugares">
                            <i class="mdi mdi-desktop-mac-dashboard"></i> <span data-key="t-widgets">Lugares</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link " href="elementos">
                            <i class="mdi mdi-desktop-mac-dashboard"></i> <span data-key="t-widgets">Elementos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link " href="reservas">
                            <i class="mdi mdi-desktop-mac-dashboard"></i> <span data-key="t-widgets">Reservas</span>
                        </a>
                    </li>
                
              
                    <?php if(Auth::user()->hasRole('admin')): ?> 
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="mdi mdi-account-circle-outline"></i> <span>Seguridad
                            </span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarDashboards">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="empresas">Empresas</a>
                                </li>
                                <li class="nav-item">
                                    <a href="usuarios" class="nav-link">Usuarios
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="roles" class="nav-link">Roles
                                    </a>
                                </li>
                                
                            </ul>
                        </div>
                    </li> 
                    <?php endif; ?>


                
                
                    

            </ul>
            
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
<?php /**PATH C:\wamp64\www\LaravelStarbell\resources\views/layouts/velzon/sidebar.blade.php ENDPATH**/ ?>
@extends('layouts.velzon.master')
@section('title', 'Elementos')
@section('content_header')
    Listado de elementos
@stop
@section('content')
    <div id="app" style="padding: 1%;">
        <div class="modal fade" id="iframeModal" tabindex="-1" role="dialog" aria-labelledby="iframeModalTitle" aria-hidden="true" style="width: 100% !important;">
            <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="iframeModalTitle">Detalles del documento</h5>
                        <button type="button" class="btn btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <iframe id="frame_vale" src="" frameborder="0" style="width:100% !important;height: 625px;"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="overflow: hidden;" id="div_main">
            <div class="card-header">
                <button class="btn btn-success w-xs btn-label waves-effect waves-light" @click="Nuevo()">
                    <i class=" ri-add-circle-fill label-icon align-middle fs-16 me-2"></i> Nuevo
                </button>
            </div>
            <div class="card-body">
                <table class="table table-nowrap table-sm table-striped dt-responsive align-middle table-hover"
                style="border-collapse: collapse; border-spacing: 0; width:100%" id="table_elementos_lugares">
                    <thead class="thead-light">
                        <th>Código</th>
                        <th>Nombre</th>
                        <th> Acciones</th>
                    </thead>
                    <tbody>
                        <tr v-for="role in lugaresTabla" @click="MostrarElementosLugares(role.id)">
                            <td>
                                <a href="javascript:void(0);" class="link-info fs-13">
                                    <strong>@{{ role.id }}</strong>
                                </a>
                            </td>
                            <td>@{{ role.nombre }}</td>
                            <td>
                                <a href="javascript:void(0);" class="link-info fs-15" :id="role.id" >
                                    <i class="ri-pencil-fill"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="div_tarjetas" style="display: none;" >
            <button class="btn btn-primary mb-3"  @click="volverMain()"><i class="fas fa-arrow-left"></i></button>
            <div class="row">

                <componente-tarjeta  v-for = "post in lugaresElementos" v-bind:key = "post.id" v-bind:item="post" v-bind:idui = "post.id" >
                </componente-tarjeta >
            </div>
        </div>
        <div class="container-fluid" style="display: none" id="div_form">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-n4 mx-n4">
                        <div class="bg-warning-subtle">
                            <div class="card-body pb-0 px-4">
                                <div class="row mb-3">
                                    <div class="col-md">
                                        <div class="row align-items-center g-3">
                                            <div class="col-md-auto">
                                                <div class="avatar-md">
                                                    <div class="avatar-title bg-white rounded-circle">
                                                        <img :src="registro.url_imagen ? registro.url_imagen:'imagenes/imagen_por_defecto.jpg'" alt="" class="avatar-xs">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div>
                                                    <h4 class="fw-bold" v-text="registro.nombre">Velzon - Admin &amp; Dashboard</h4>
                                                    <div class="hstack gap-3 flex-wrap">
                                                        {{-- <div><i class="ri-building-line align-bottom me-1"></i> Themesbrand</div> --}}
                                                        {{-- <div class="vr"></div> --}}
                                                        <div>Fecha Creacion : <span class="fw-medium" v-text="registro.fecha_crea">15 Sep, 2021</span></div>
                                                        <div class="vr"></div>
                                                        <div>Fecha Actualización : <span class="fw-medium" v-text="registro.fecha_modifica">29 Dec, 2021</span></div>
                                                        <div class="vr"></div>
                                                        {{-- <div class="badge rounded-pill bg-info fs-12">New</div>
                                                        <div class="badge rounded-pill bg-danger fs-12">High</div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-auto">
                                        <div class="hstack gap-1 flex-wrap">
                                            <button class="btn btn-success" @click="Crear()" v-if="botonMostrar=='Nuevo'">Guardar</button>
                                            <button class="btn btn-success" @click="Actualizar()" v-else>Actualizar</button>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                                    <li class="nav-item" role="presentation">                                      
                                        <a class="nav-link" @click="volverTarjeta()">
                                            <i class="fas fa-arrow-left"></i>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link fw-semibold active" data-bs-toggle="tab" href="#project-overview" role="tab" aria-selected="true">
                                            Resumen
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#project-documents" role="tab" aria-selected="false" tabindex="-1">
                                            Imagenes
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#project-activities" role="tab" aria-selected="false" tabindex="-1">
                                            Reservas
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item" role="presentation">
                                        <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#project-team" role="tab" aria-selected="false" tabindex="-1">
                                            Team
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>
                            <!-- end card body -->
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-content text-muted">
                        <div class="tab-pane fade active show" id="project-overview" role="tabpanel">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    
                                                        <div class="mb-1">
                                                            <label class="form-label" for="project-title-input">Lugar</label>
                                                            <select id="sel_lugar" name="" class="form-control select2">
                                                                <option value="0">Seleccione...</option>
                                                                <option v-for="reg in lugares" :value="reg.id" v-text="reg.nombre">
                                                                </option>
                                                            </select>
                                                        </div>
                                                    
                                                </div>
                                                <div class="col-6">
                                                    
                                                    <div class="mb-1">
                                                        <label class="form-label" for="project-title-input">Tipo Reservable</label>
                                                        <select id="sel_tipo_reservables" name="" class="form-control select2">
                                                            <option value="0">Seleccione...</option>
                                                            <option v-for="reg in reservables" :value="reg.id" v-text="reg.nombre">
                                                            </option>
                                                        </select>
                                                    </div>
                                                
                                                </div>
                                                
                                                <div class="col-6">                                                    
                                                        <div class="mb-1">
                                                            <label class="form-label" for="project-title-input">Nombre</label>
                                                            <input type="text" class="form-control" id="project-title-input" v-model="registro.nombre" placeholder="Ingrese nombre">
                                                        </div>                                                  
                                                </div>
                                                <div class="col-6">                                                    
                                                    <div class="mb-1">
                                                        <label class="form-label" for="project-title-input">Valor</label>
                                                        <input type="text" class="form-control" v-model="registro.valor" placeholder="Ingrese valor">
                                                    </div>                                              
                                                </div>
                                                <div class="col-2">                                                  
                                                        <div class="mb-1">
                                                            <label class="form-label" for="project-title-input">Capacidad Personas</label>
                                                            <input type="number" class="form-control" id="project-title-input" v-model="registro.numero_capacidad" placeholder="Ingrese cantidad">
                                                        </div>
                                                    
                                                </div>
                                                <div class="col-2">
                                                    
                                                        <div class="mb-1">
                                                            <label class="form-label" for="project-title-input">Hora Inicio </label>
                                                            <input type="time" class="form-control" id="project-title-input" v-model="registro.hora_inicio_disponibilidad" placeholder="Enter project title">
                                                        </div>
                                                    
                                                </div>
                                                <div class="col-2">
                                                    
                                                        <div class="mb-1">
                                                            <label class="form-label" for="project-title-input">Hora Fin </label>
                                                            <input type="time" class="form-control" id="project-title-input" v-model="registro.hora_fin_disponibilidad" placeholder="Enter project title">
                                                        </div>
                                                    
                                                </div>
                                                <div class="col-12">
                                                    
                                                            <div class="mb-1">
                                                            <label class="form-label" for="project-title-input">Dias Disponible</label>
                                                            <div class="row" style="padding: 2em;">
                                                                <div class="form-check form-check-success mb-1 col-3">
                                                                    <input class="form-check-input" type="checkbox"  v-model="registro.lunes" checked="">
                                                                    <label class="form-check-label" for="formCheck8">
                                                                        Lunes
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-success mb-1 col-3">
                                                                    <input class="form-check-input" type="checkbox" v-model="registro.martes"  checked="">
                                                                    <label class="form-check-label" for="formCheck8">
                                                                        Martes
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-success mb-1 col-3">
                                                                    <input class="form-check-input" type="checkbox" v-model="registro.miercoles"  checked="">
                                                                    <label class="form-check-label" for="formCheck8">
                                                                        Miercoles
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-success mb-1 col-3">
                                                                    <input class="form-check-input" type="checkbox" v-model="registro.jueves"  checked="">
                                                                    <label class="form-check-label" for="formCheck8">
                                                                        Jueves
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-success mb-1 col-3">
                                                                    <input class="form-check-input" type="checkbox" v-model="registro.viernes"  checked="">
                                                                    <label class="form-check-label" for="formCheck8">
                                                                        Viernes
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-success mb-1 col-3">
                                                                    <input class="form-check-input" type="checkbox" v-model="registro.sabado"  checked="">
                                                                    <label class="form-check-label" for="formCheck8">
                                                                        Sabado
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-success mb-1 col-3">
                                                                    <input class="form-check-input" type="checkbox" v-model="registro.domingo"  checked="">
                                                                    <label class="form-check-label" for="formCheck8">
                                                                        Domingo
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    
                                                </div>
                                                <div class="col-12">
                                                    
                                                        <div class="mb-1">
                                                            <label class="form-label" for="project-title-input">Descripción</label>
                                                            {{-- <input type="text" class="form-control" id="project-title-input" placeholder="Enter project title"> --}}
                                                            <textarea  class="form-control" placeholder="Por favor ingrese descripción del elemento" v-model="registro.descripcion"></textarea>
                                                        </div>                                               
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    <!-- end card -->                                   
                                    <!-- end card -->
                                </div>
                                <!-- ene col -->                              
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end tab pane -->
                        <div class="tab-pane fade" id="project-documents" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-4">
                                        <h5 class="card-title flex-grow-1">Imagenes</h5>
                                        <div class="row">
                                            <div class="input-group ">
                                                <input type="file" class="form-control" id="txt_archivo" accept=".png, .jpg">
                                                <button class="btn btn-outline-success" type="button" id="inputGroupFileAddon04" @click="SubirImagenElemento()" >Cargar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class=" table-card">
                                                <table class="table table-borderless align-middle mb-0">
                                                    <thead class="table-light">
                                                        <tr >
                                                            <th scope="col">Nombre Archivo</th>
                                                            <th scope="col">Tipo</th>
                                                            <th scope="col">Tamaño</th>
                                                            <th scope="col">Fecha Creación</th>
                                                            <th scope="col" style="width: 120px;">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                      
                                                        <tr v-for="item in elementos_imagenes">
                                                            <td @click="MostrarArchivo(item.url,item.extension)">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar-sm">
                                                                        <div class="avatar-title bg-light text-danger rounded fs-24">
                                                                            <img :src="item.url" height="50" alt="" srcset="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="ms-3 flex-grow-1">
                                                                        <h5 class="fs-14 mb-0"><a href="javascript:void(0);" class="text-body" v-text="item.nombre"></a></h5>
                                                                        <span class="badge border border-success text-success" v-show="item.imagen_principal==1">Principal</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><span v-text="item.extension"></span> File</td>
                                                            <td><span v-text="item.tamano"></span> MB</td>
                                                            <td v-text="item.fecha_crea">02 Nov 2021</td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <a href="javascript:void(0);" class="btn btn-soft-secondary btn-sm btn-icon" data-bs-toggle="dropdown" aria-expanded="true">
                                                                        <i class="ri-more-fill"></i>
                                                                    </a>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li><a class="dropdown-item" href="javascript:void(0);" @click="SeleccionarImagenPrincipal(item.id)"><i class="ri-image-fill me-2 align-bottom text-muted"></i>Imagen principal</a></li>
                                                                        <li><a class="dropdown-item" href="javascript:void(0);" @click="MostrarArchivo(item.url,item.extension)"><i class="ri-eye-fill me-2 align-bottom text-muted"></i>Ver</a></li>
                                                                        
                                                                        <li><a class="dropdown-item" :href="item.url" target="_blank" rel="noopener noreferrer" ><i class="ri-download-2-fill me-2 align-bottom text-muted"></i>Descargar</a></li>
                                                                        <li class="dropdown-divider"></li>
                                                                        <li><a class="dropdown-item" @click="EliminarImagenElemento(item.id)" href="javascript:void(0);"><i class="ri-delete-bin-5-fill me-2 align-bottom text-muted"></i>Eliminar</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center mt-3">
                                                <a href="javascript:void(0);" class="text-success "><i class="mdi mdi-loading mdi-spin fs-20 align-middle me-2"></i> Load more </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end tab pane -->
                        <div class="tab-pane fade" id="project-activities" role="tabpanel">
                            <div class="card">
                            </div>
                        </div>
                        <!-- end tab pane -->
                        <div class="tab-pane fade" id="project-team" role="tabpanel">
                        </div>
                        <!-- end tab pane -->
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Role</h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"
                            @click="CerrarModal()"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="mb-3">
                                <label class="form-label" for="">Nombre</label>
                                <input type="text" v-model="registro.name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label class="form-label" for="">Descripción</label>
                                <input type="text" v-model="registro.descripcion" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"
                            @click="CerrarModal()">Cerrar</button>
                        <button type="button" class="btn btn-success btn-sm" @click="Crear()"
                            v-if="botonMostrar=='Nuevo'">Guardar</button>
                        <button type="button" class="btn btn-success btn-sm" @click="Actualizar()"
                            v-else>Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal -->
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* .btn-close{
            background-color: red;
        color: white;
        } */
    </style>
@stop
@section('js')
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.js"
        integrity="sha512-otOZr2EcknK9a5aa3BbMR9XOjYKtxxscwyRHN6zmdXuRfJ5uApkHB7cz1laWk2g8RKLzV9qv/fl3RPwfCuoxHQ=="
        crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> -->
    <script src="/js/global.js"></script>
    <script src="/js/elementos_lugares/componentes/card-elementos.js"></script>
    <script src="/js/elementos_lugares/elementos_lugares.js"></script>
@stop

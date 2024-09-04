@extends('layouts.velzon.master')
@section('title', 'Usuarios')
@section('content_header')
    Listado de usuarios
@stop
@section('content')
    <div id="app" style="padding: 1%;">
        <div class="modal fade" id="iframeModal" tabindex="-1" role="dialog" aria-labelledby="iframeModalTitle"
            aria-hidden="true" style="width: 100% !important; ">
            <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="iframeModalTitle">Detalles del documento</h5>
                        <button type="button" class="btn btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <iframe id="frame_vale" src="" frameborder="0"
                            style="width:100% !important;height: 100%;"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" id="div_main" style="overflow: hidden;">
            <div class="card-header">
                <button class="btn btn-success w-xs btn-label waves-effect waves-light" @click="Nuevo()">
                    <i class=" ri-add-circle-fill label-icon align-middle fs-16 me-2"></i> Nuevo
                </button>
            </div>
            <div class="card-body">
                <table class="table table-nowrap table-sm table-striped dt-responsive align-middle table-hover"
                    style="border-collapse: collapse; border-spacing: 0; width:100%" id="table_usuarios">
                    <thead class="thead-light">
                        <th class="all"  >Código</th>
                        <th class="none" >Nombre</th>
                        <th class="none" >Apellidos</th>
                        <th class="none" >Identificación</th>
                        <th class="none" >Regional</th>
                        <th class="none" >Cargo</th> 
                        <th class="none" >Rol</th>
                        <th class="none" >Acciones</th>
                    </thead>
                    <tbody>
                        <tr v-for="user in usuarios">
                            <td>
                                <a href="javascript:void(0);" class="link-info fs-13" @click="Mostrar(user.id)">
                                    <strong>@{{ user.id }}</strong>
                                </a>
                            </td>
                            <td>@{{ user.name }}</td>
                            <td>@{{ user.apellidos }}</td>
                            <td>@{{ user.identificacion }}</td>
                            <td>@{{ user.NomZonas }}</td>
                            <td>@{{ user.nombre_cargo}}</td>
                            <td>@{{ user.descript }}</td>
                            <td>
                                <a href="javascript:void(0);" class="link-info fs-15" @click="Mostrar(user.id)">
                                    <i class="ri-pencil-fill"></i>
                                </a>
                                <a href="javascript:void(0);" class="link-danger fs-15" @click="Eliminar(user.id)">
                                    <i class="ri-delete-bin-fill align-bottom"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" style="display: none" id="div_detalle">
            <div class="col-md-9">
                <div class="card" style="padding: 1em;">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0"
                                    role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link fs-14 " @click="VolverMain()">
                                            <i class="ri-arrow-left-fill"></i> <span class="d-md-inline-block"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails"
                                            id="Informacion_form" role="tab" aria-selected="true">
                                                Datos Generales
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword"
                                            role="tab" aria-selected="false" tabindex="-1">
                                                Documentos
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-4  d-flex align-items-center" >                                 
                                <label class="form-check-label mx-3" for="customSwitchsizelg" style="margin-left: 20px;">Estado</label>
                                <div class="form-check form-switch form-switch-lg flex-grow-2" dir="ltr">
                                    <input type="checkbox" class="form-check-input accion" id="customSwitchsizelg" checked="" v-model="registro.estado">
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <button class="btn btn-sm btn-success " @click="Crear()"  v-if="botonMostrar=='Nuevo'"><i class="fas fa-save"></i>&nbsp;Guardar</button>
                                        <button class="btn btn-sm btn-success " @click="Actualizar()"  v-if="botonMostrar=='Mostrar'" ><i class="fas fa-save"></i>&nbsp;Actualizar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="personalDetails" role="tabpanel">           
                                <div class="row">
                                    <div class="col-md-6" v-show="Tipouser=='admin'">
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label class="form-label" for="">Empresa</label> 
                                                <select id="sel_empresa" name="" class="form-control select2">
                                                    <option value="0">Seleccione...</option>
                                                    <option v-for="reg in empresas_sistemas" :value="reg.id">
                                                        @{{ reg.nombre }} @{{ reg.identificacion }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label class="form-label" for="">Nombre</label>
                                                <input type="text" v-model="registro.name" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label class="form-label" for="">Apellido</label>
                                                <input type="text" v-model="registro.apellidos" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label class="form-label" for="">Identificación</label>
                                                <input type="text" v-model="registro.identificacion" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label class="form-label" for="">Correo Electrónico</label>
                                                <input type="text" v-model="registro.email" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label class="form-label" for="">Rol</label>
                                                <select id="sel_registro_role" class="accion form-control select2">
                                                    <option value="0">Seleccione...</option>
                                                    <option v-for="role in roles" :value="role.id">@{{ convertirAMayusculas(role.description) }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>                                 
                                    <div class="col-md-6">
                                        <div id="div_categorias" style="display: none;">
                                            <div class="mb-3">
                                                <label class="form-label" for="">Categorías</label>
                                                <select id="sel_registro_categoria" name="" class="form-control select2"
                                                    name="categorias[]" multiple="multiple">
                                                    <option v-for="cat in categorias" :value="cat.id">
                                                        @{{ cat.descripcion }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>         
                                </div>   
                            </div>
                            <div class="tab-pane" id="changePassword" role="tabpanel">
                                <form action="javascript:void(0);">
                                    <div class="row g-2">
                                        <div class="col-lg-5">
                                            <div>
                                                <label for="oldpasswordInput" class="form-label">Tipo
                                                    Documento</label>
                                                <select name="" id="sel_id_tipo_documentos"
                                                    class="accion form-control select2">
                                                    <option value="0">Seleccione...</option>
                                                    <option v-for="opt in tipo_documentos"
                                                        :value="opt.id">@{{ opt.nombre }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">Documento</label>
                                                <input type="file" class="form-control accion"
                                                    id="file-documento">
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <div>
                                                <button type="submit" class="btn btn-success btnaccion"
                                                    @click="GuardarDocumentoUsuario()" style="position: relative;top:26px;">Subir</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end row-->
                                </form>
                                <div class="mt-4 mb-3 border-bottom pb-2">
                                            <h5 class="card-title">Documentos</h5>
                                        </div>
                                        <div class="d-flex align-items-center mb-3" v-for="poc in users_documentos"> 
                                            <div class="flex-shrink-0 avatar-sm"
                                                @click="mostrarArchivo(poc.url,poc.extension)">
                                                <div class="avatar-title bg-light text-primary rounded-3 fs-18 shadow">                                                  
                                                    <i class="ri-file-pdf-fill" v-if="poc.extension === 'pdf'"
                                                        style="color: red;"></i>
                                                    <i class="ri-video-line" v-else-if="poc.extension === 'mp4'"
                                                        style="color: yellow;"></i>
                                                    <i class="ri-file-excel-fill"
                                                        v-else-if="poc.extension === 'xlxs' || poc.extension === 'xls' "
                                                        style="color: green;"></i>
                                                    <i class="ri-folder-fill" v-else-if="poc.extension === 'docx'"
                                                        style="color: blue;"></i>
                                                    <i class="ri-image-2-fill"
                                                        v-else-if="poc.extension === 'png' || poc.extension === 'jpg' || poc.extension === 'jpeg'"
                                                        style="color: blue;"></i>
                                                    <i class="ri-folder-zip-line" v-else-if="poc.extension === 'zip'"
                                                        style="color: blue;"></i>
                                                    <i class="ri-file-ppt-fill"
                                                        v-else-if="poc.extension === 'ppt' || poc.extension === 'pptx'"
                                                        style="color: orange;"></i>
                                                    <i class="ri-file-word-fill" v-else-if="poc.extension === 'doc'"
                                                        style="color: blue;"></i>
                                                    <i class="ri-file-excel-fill" v-else-if="poc.extension === 'xlsx'"
                                                        style="color: green;"></i>
                                                    <i class="ri-file-text-fill"
                                                        v-else-if="poc.extension === 'txt'"></i>
                                                    <i class="ri-file-unknown-fill" v-else></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3"
                                                @click="mostrarArchivo(poc.url,poc.extension)">
                                                <h6 v-text="poc.nombre_documento">Nombre Documento</h6>
                                                <p class="text-muted mb-0" v-text="poc.fecha_fin"></p>
                                            </div>
                                            <div>                                              
                                                <div class="hstack gap-3 fs-15">                                                
                                                    <a href="javascript:void(0);" class="link-danger btnaccion"
                                                        @click="EliminarDocumentoUsuario(poc.id)"><i
                                                            class="ri-delete-bin-5-line"></i></a>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                        </div>                   
                    </div>
                </div>
            </div>
            <div class="col-md-3" >              
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title mb-0 flex-grow-1">Firma</h4>
                        </div>
                    </div>
                    <div class="card-body" v-show="botonMostrar!='Ver'" >
                        <div class="mb-2">
                            <span class="text-muted">Agregar Firma </span>
                        </div>
                        <div class="dropzoneAdjuntoCliente border-dashed" style="border-color:rgb(236, 236, 236) !important;text-align: center;">
                            <div class="fallback">
                                <input name="file" type="file" multiple="multiple">
                            </div>
                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted ri-upload-cloud-2-fill" style="color: rgb(223, 223, 223)!important;"></i>
                                </div>
                                <h5 class="text-muted" style="font-size: 15px;">Arrastre y suelte un archivo aquí o haga clic</h5>
                            </div>
                        </div>
                    </div> 
                    <div class="card-body">
                        <div class="vstack gap-2">
                            <div class="border rounded border-dashed p-2"   v-show="adjuntoUsuario!=''">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-sm">
                                            <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                <i class="ri-image-2-line" 
                                                ></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                    </div>
                                    <div class="flex-shrink-0 ms-2">
                                        <div class="d-flex gap-1">
                                            <a :href='adjuntoUsuario.imgFirma' target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-sm btn-icon text-muted  fs-18"><i class="ri-eye-2-line"></i></button></a>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-icon text-muted  fs-18 dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" @click="MostrarArchivo(adjuntoUsuario.imgFirma)" href="#" ><i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                        Ver</a></li>                                                  
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal -->
        <div class="modal fade bd-example-modal-sm" id="modalFechaVencimiento" tabindex="-1" role="dialog"
            aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title m-0" id="mySmallModalLabel">Cambiar fecha de vencimiento </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <div class="modal-body text-center">
                        <label class="form-label" for="">Fecha de vencimiento membresía</label>
                        <input type="date" class="form-control" v-model="registro.fechaVencimiento">
                    </div><!--end modal-body-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-soft-success btn-sm"
                            @click="actualizarFechaVencimiento()">Actualizar</button>
                        <button type="button" class="btn btn-soft-secondary btn-sm"
                            data-bs-dismiss="modal">Cerrar</button>
                    </div><!--end modal-footer-->
                </div><!--end modal-content-->
            </div><!--end modal-dialog-->
        </div><!--end modal-->
        <!-- Modal -->
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
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="/js/global.js"></script>
    <script src="/js/usuarios/usuarios.js?v=<?php echo date('YmdHis'); ?>"></script>
    <script>
        var dropzone = new Dropzone(".dropzoneAdjuntoCliente", {
            url: 'guardarArchivoUsuario',
            method: "post",
            // previewTemplate: previewTemplate,
            // previewsContainer: "#dropzone-preview",
            // acceptedFiles: ".xls,.xlsx",
            init: function() {
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                this.on("sending", function(file, xhr, formData) {
                    // Agregar parámetros adicionales al objeto formData
                    // formData.append("param1", "valor1");
                    // formData.append("param2", "valor2");
                    formData.append("_token", csrfToken); 
                    formData.append("data", JSON.stringify(vm.registro)); 
                });
                this.on("complete", function(fileDato) {
                    // Lógica después de que se complete la carga del archivo
                    console.log("Archivo cargado:", fileDato.name);
                    // Aquí puedes realizar cualquier otra acción que necesites después de que se complete la carga del archivo
                    //    ListarArchivosContrato();
                    vm.ListarArchivosUsuario();
                    // Por ejemplo, si deseas eliminar el archivo de la lista de archivos cargados y realizar una acción adicional:
                    this.removeFile(fileDato);
                });
            }
        });
    </script>
@stop

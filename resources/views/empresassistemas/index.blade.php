@extends('layouts.velzon.master')

@section('title', 'empresas')
@section('content_header')
    Listado de empresas
@stop
@section('content')
    <div id="app" style="padding: 1%;">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-success w-xs btn-label waves-effect waves-light" @click="Nuevo()">
                    <i class=" ri-add-circle-fill label-icon align-middle fs-16 me-2"></i> Nuevo
                </button>
            </div>
            {{-- <div class="btn-group-sm" style=" padding: 1%;">
                <button class="btn btn-success btn-sm" @click="Nuevo()"><i class="fas fa-save"></i>&nbsp;Nuevo</button>
            </div> --}}
            <div class="card-body">
                <table class="table table-nowrap table-sm table-striped dt-responsive align-middle table-hover"
                    style="border-collapse: collapse; border-spacing: 0; width:100%" id="table_empresas">
                    <thead class="thead-light">
                         <th>#</th> 
                        <th>Nombre</th>
                        {{-- <th>Descripción</th> --}}
                        <th class="all"> Acciones</th>
                    </thead>
                    <tbody>
                        <tr v-for="(role,index) in empresas">
                            <td>
                                <a href="javascript:void(0);" class="link-info fs-13">
                                    <strong>@{{ index + 1 }}</strong>
                                </a>
                            </td> 
                            <td>@{{ role.nombre }}</td>
                            {{-- <td>@{{ role.description }}</td> --}}
                            <td>
                                {{-- <button class="btn btn-sm btn-warning btnmostrarv" :id="role.id" @click="Mostrar(role.id)" title="Editar"><i class="far fa-edit" style="color:white;"></i>&nbsp;</button> --}}
                                {{-- <button class="btn  btn-sm btn-danger btneliminarv" :id="role.id"  @click="Eliminar(role.id)" title="Eliminar"><i class="fas fa-trash-alt"></i>&nbsp;</button> --}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Empresa</h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"
                            @click="CerrarModal()"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="mb-3">
                                <label class="form-label" for="">Identificación</label>
                                <input type="text" v-model="registro.identificacion" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label class="form-label" for="">Nombre</label>
                                <input type="text" v-model="registro.nombre" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label class="form-label" for="">Email</label>
                                <input type="text" v-model="registro.email" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-sm" @click="Crear()"
                            v-if="botonMostrar=='Nuevo'">Guardar</button>
                        <button type="button" class="btn btn-success btn-sm" @click="Actualizar()"
                            v-else>Actualizar</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"
                            @click="CerrarModal()">Cerrar</button>

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
    <!-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> -->
    <script src="/js/global.js"></script>
    <script src="/js/empresassistemas/empresassistemas.js"></script>
@stop

@extends('layouts.dastone')
@section('title', 'basicos')
@section('content_header')
    Listado Básicos
@stop
@section('content')
    <div  id="app" style="padding: 1%;">
            <div class="card">
            <div class="btn-group-sm" style=" padding: 1%;">
            <button class="btn btn-success btn-sm" @click="Nuevo()"><i class="fas fa-save"></i>&nbsp;Nuevo</button>
            </div>
            <div style="padding: 1%; ">
                <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;visibility:hidden;"   id="table_basicos">
                    <thead class="thead-light">
                        <th class="all" >Código</th>
                        <th class="all">Nombre</th>
                        {{-- <th>Descripción</th> --}}
                        <th class="all"> Acciones</th>
                    </thead>
                    <tbody>
                    <tr v-for="role in basicos">
                    <td>@{{role.id}}</td>
                    <td>@{{role.nombre}}</td>
                    {{-- <td>@{{role.description}}</td> --}}
                    <td>
                    <button  title="ver" class="btn btn-sm  btn-info " :id="role.id" @click="Mostrar(role.id,'ver')"><i id="1" class="far fa-eye " style="color: white;"></i></button>
                    <button class="btn btn-sm btn-warning btnmostrarv" :id="role.id" @click="Mostrar(role.id,'editar')" title="Editar"><i class="far fa-edit" style="color:white;"></i>&nbsp;</button>
                    <button class="btn  btn-sm btn-danger btneliminarv" :id="role.id"  @click="Eliminar(role.id)" title="Eliminar"><i class="fas fa-trash-alt"></i>&nbsp;</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Basico</h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close" @click="CerrarModal()"></button>
                </div>
                <div class="modal-body">

                  <div class="row">
                      <div class="col-xs-6 col-sm-6	col-md-6 col-lg-6">
                        <div class="form-group">
                          <div class="mb-3">
                                  <label class="form-label" for="">Nombre</label>
                              <input type="text" v-model="registro.nombre" class="form-control accion">
                          </div>
                      </div>
                      <div class="form-group">
                        <div class="mb-3">
                          <label class="form-label" for="">Dirección</label>
                          <input type="text" v-model="registro.direccion" class="form-control accion">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="mb-3">
                          <label class="form-label" for="">Red Social 1</label>
                          <input type="text" v-model="registro.redSocial1" class="form-control accion">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="mb-3">
                          <label class="form-label" for="">Teléfono 2</label>
                          <input type="text" v-model="registro.telefono2" class="form-control accion">
                        </div>
                      </div>
                      </div>
                      <div class="col-xs-6 col-sm-6	col-md-6 col-lg-6">
                        <div class="form-group">
                          <div class="mb-3">
                            <label class="form-label" for="">Red Social 2</label>
                            <input type="text" v-model="registro.redSocial2" class="form-control accion">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="mb-3">
                            <label class="form-label" for="">Red Social 3</label>
                            <input type="text" v-model="registro.redSocial3" class="form-control accion">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="mb-3">
                            <label class="form-label" for="">Teléfono</label>
                            <input type="text" v-model="registro.telefono1" class="form-control accion">
                          </div>
                        </div>
                      
                      </div>
                  </div>
                    
                   
                  
                    <div class="form-group row">
                    <input type="file" id="file_imagen" name="file_imagen"
                    class="dropify" data-default-file />
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" @click="CerrarModal()">Cerrar</button>
                    <button type="button" class="btn btn-success btn-sm"  @click="Crear()" v-if="botonMostrar=='Nuevo'">Guardar</button>
                    <button id="btn_actualizar" type="button" class="btn btn-success btn-sm" @click="Actualizar()" v-else>Actualizar</button>
                </div>
                </div>
            </div>
            </div>
            <!-- fin modal -->
    </div>
@stop
@section('css')   
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" integrity="sha512-cyzxRvewl+FOKTtpBzYjW6x6IAYUCZy3sGP40hn+DQkqeluGRCax7qztK2ImL64SA+C7kVWdLI6wvdlStawhyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
     /* .btn-close{
        background-color: red;
    color: white;
    } */
    .cropper-view-box,
    .cropper-face {
      border-radius: 50%;
    }
    /* The css styles for `outline` do not follow `border-radius` on iOS/Safari (#979). */
    .cropper-view-box {
        outline: 0;
        box-shadow: 0 0 0 1px #39f;
    }
    </style>
@stop
@section('js')
{{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.js" integrity="sha512-otOZr2EcknK9a5aa3BbMR9XOjYKtxxscwyRHN6zmdXuRfJ5uApkHB7cz1laWk2g8RKLzV9qv/fl3RPwfCuoxHQ==" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> -->
<script src="/js/global.js"></script> 
<script src="/js/basicos/basicos.js"></script> 
<script>
    // const image = document.getElementById('file_imagen_edit');
    // const cropper = new Cropper(image, {
    // aspectRatio: 16 / 9,
    // crop(event) {
    //     console.log(event.detail.x);
    //     console.log(event.detail.y);
    //     console.log(event.detail.width);
    //     console.log(event.detail.height);
    //     console.log(event.detail.rotate);
    //     console.log(event.detail.scaleX);
    //     console.log(event.detail.scaleY);
    // },
    // });
    function getRoundedCanvas(sourceCanvas) {
      var canvas = document.createElement('canvas');
      var context = canvas.getContext('2d');
      var width = sourceCanvas.width;
      var height = sourceCanvas.height;
      canvas.width = width;
      canvas.height = height;
      context.imageSmoothingEnabled = true;
      context.drawImage(sourceCanvas, 0, 0, width, height);
      context.globalCompositeOperation = 'destination-in';
      context.beginPath();
      context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
      context.fill();
      return canvas;
    }
    // window.addEventListener('DOMContentLoaded', function () {
    // });
  //   var el = document.getElementById("btn_mostrar_edit");
  // el.addEventListener("click", function(){
  //   var image = document.getElementById('file_imagen_edit');
  //     var button = document.getElementById('btn_recortar');
  //     var result = document.getElementById('result');
  //     var croppable = false;
  //     var cropper = new Cropper(image, {
  //       aspectRatio: 16 / 9,
  //       // viewMode: 1,
  //       ready: function () {
  //         croppable = true;
  //       },
  //     });
  //     button.onclick = function () {
  //       var croppedCanvas;
  //       var roundedCanvas;
  //       var roundedImage;
  //       if (!croppable) {
  //         return;
  //       }
  //       // Crop
  //       croppedCanvas = cropper.getCroppedCanvas();
  //       // Round
  //       roundedCanvas = getRoundedCanvas(croppedCanvas);
  //       // Show
  //       roundedImage = document.createElement('img');
  //       roundedImage.src = roundedCanvas.toDataURL()
  //       roundedImage.id = 'txt_img_redondeda'
  //       result.innerHTML = '';
  //       result.appendChild(roundedImage);
  //     };
  // }, false);
</script>
@stop
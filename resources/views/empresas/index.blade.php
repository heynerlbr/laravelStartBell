@extends('layouts.velzon.master')
@section('title', 'Básicos')
@section('content_header')
    Listado de empresas
@stop

@section('content')
    <div id="app">
        <div id="pagina_principal">

            <div class="container-fluid">

                <div class="position-relative mx-n4 mt-n4">
                    <div class="profile-wid-bg profile-setting-img">
                        <img src="imagenes/Portada.jpg" class="profile-wid-img" alt="">
                        <div class="overlay-content">
                            <div class="text-end p-3">
                                <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                                    <input id="profile-foreground-img-file-input" type="file"
                                        class="profile-foreground-img-file-input">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card mt-n5">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                        <img :src="imagenEmpresa!='' ? imagenEmpresa:'imagenes/avatar.png'" class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                            alt="user-profile-image">
                                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                            <input id="profile-img-file-input" type="file" class="profile-img-file-input">
                                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                <span class="avatar-title rounded-circle bg-light text-body">
                                                    <i class="ri-camera-fill"></i>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <h5 class="fs-16 mb-1"></h5>
                                    <p class="text-muted mb-0">Empresa / Cliente </p> 
                                </div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>

                    <!--end col-->
                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails"
                                            role="tab" aria-selected="true">
                                            <i class="fas fa-home"></i> Datos Básicos
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab"
                                            aria-selected="false" tabindex="-1">
                                            <i class="far fa-user"></i> Portafolio
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#experience" role="tab"
                                            aria-selected="false" tabindex="-1">
                                            <i class="far fa-envelope"></i> Envío Correos
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>

                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active show" id="personalDetails" role="tabpanel">
                                        <form action="javascript:void(0);">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="firstnameInput" class="form-label">Nombre</label>
                                                        <input type="text" class="form-control"  :value="Perfil.nombre"
                                                            placeholder="" disabled>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="phonenumberInput" class="form-label">Identificación</label>
                                                        <input type="text" class="form-control"  :value="Perfil.identificacion"
                                                            placeholder="" disabled>
                                                    </div>
                                                </div>
                                                {{-- <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="emailInput" class="form-label">Email Address</label>
                                                        <input type="email" class="form-control" id="emailInput"
                                                            placeholder="Enter your email" value="daveadame@velzon.com">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="zipcodeInput" class="form-label">Dirección</label>
                                                        <input type="text" class="form-control" minlength="5"
                                                            maxlength="6" id="zipcodeInput" placeholder="Enter zipcode">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="cityInput" class="form-label">Ciudad</label>
                                                        <input type="text" class="form-control" id="cityInput"
                                                            placeholder="City" value="California">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-12">
                                                    <div class="mb-3 pb-2">
                                                        <label for="exampleFormControlTextarea"
                                                            class="form-label">Descripción</label>
                                                        <textarea class="form-control" id="exampleFormControlTextarea" placeholder="Enter your description" rows="3">Hi I'm Anna Adame,It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is European languages are members of the same family.</textarea>
                                                    </div>
                                                </div> --}}
                                                <!--end col-->
                                                {{-- <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-success">Actualizar</button>
                                                      
                                                    </div>
                                                </div> --}}

                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                    <!--end tab-pane-->

                                    {{-- <div class="tab-pane" id="changePassword" role="tabpanel">
                                        <div class="card-body">
                                            <div class="mb-3 d-flex">
                                                <div class="avatar-xs d-block flex-shrink-0 me-3">
                                                    <span class="avatar-title rounded-circle fs-16 bg-dark">
                                                        <i class="ri-global-fill"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" id="websiteInput"
                                                    placeholder="www.example.com" value="www.velzon.com">
                                            </div>
                                            <div class="mb-3 d-flex">
                                                <div class="avatar-xs d-block flex-shrink-0 me-3">
                                                    <span class="avatar-title rounded-circle fs-16 bg-primary text-light">
                                                        <i class="ri-facebook-fill"></i>
                                                    </span>
                                                </div>
                                                <input type="email" class="form-control" id="gitUsername"
                                                    placeholder="Username" value="@daveadame">
                                            </div>
                                            <div class="mb-3 d-flex">
                                                <div class="avatar-xs d-block flex-shrink-0 me-3">
                                                    <span class="avatar-title rounded-circle fs-16 bg-info">
                                                        <i class="ri-twitter-fill"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" id="dribbleName"
                                                    placeholder="Username" value="@dave_adame">
                                            </div>
                                            <div class="d-flex">
                                                <div class="avatar-xs d-block flex-shrink-0 me-3">
                                                    <span class="avatar-title rounded-circle fs-16 bg-danger">
                                                        <i class="ri-instagram-fill"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" id="pinterestName"
                                                    placeholder="Username" value="Advance Dave">
                                            </div>
                                        </div>
                                    </div> --}}
                                    <!--end tab-pane-->

                                    {{-- <div class="tab-pane show" id="experience" role="tabpanel">
                                        <h6 class="fs-14 mb-1">Configuración SMTP</h6>
                                        <p class="text-muted">Agrega la configuración SMTP de tu correo para el envío de
                                            correos corporativos.</p>

                                        <form action="javascript:void(0);">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="phonenumberInput" class="form-label">SMTP</label>
                                                        <input type="text" class="form-control" id="phonenumberInput"
                                                            placeholder="Enter your phone number" value="+(1) 987 6543">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="emailInput" class="form-label">Puerto</label>
                                                        <input type="email" class="form-control" id="emailInput"
                                                            placeholder="Enter your email" value="daveadame@velzon.com">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="emailInput" class="form-label">Correo</label>
                                                        <input type="email" class="form-control" id="emailInput"
                                                            placeholder="Enter your email" value="daveadame@velzon.com">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="zipcodeInput" class="form-label">Contraseña</label>
                                                        <input type="password" class="form-control" minlength="5"
                                                            maxlength="6" id="zipcodeInput" placeholder="Enter zipcode"
                                                            value="90011">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="cityInput" class="form-label">Confirmar
                                                            Contraseña</label>
                                                        <input type="password" class="form-control" id="cityInput" placeholder="City" value="California">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-primary">Updates</button>
                                                        <button type="button" class="btn btn-soft-success">Cancel</button>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div> --}}
                                    <!--end tab-pane-->

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

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
        <style>
            .Pruebade {
                width: 60px;
            }
    
            .page-link.active,
            .active>.page-link {
                background-color: #656e92;
                border-color: #656e92;
            }
    
            .profile-wid-bg:before {
                background: rgb(31, 31, 61);
                opacity: 0.4;
            }
    
            .team-box .team-cover:before,
            .profile-offcanvas .team-cover:before,
            .modal-team-cover:before {
                /* background : rgb(220, 220, 235); */
                background: none;
            }
    
            .hidden {
                display: none;
            }
    
            .campoUnidad {
                padding-left: none;
            }
    
            .marginsettings {
                margin-right: 0.5em;
            }
    
            /* placa para mostrar en la car */
            .placa-carro {
                background-color: #FFD700;
                /* Amarillo dorado */
                color: #000;
                /* Texto en negro */
                padding: 6px 11px;
                /* Relleno */
                border-radius: 5px;
                /* Bordes redondeados */
                text-align: center;
                font-weight: bold;
                font-size: 16px;
                /* Tamaño de fuente */
                width: 95px;
                /* Ancho máximo */
                margin: 5px;
                /* Márgenes exteriores */
                display: inline-block;
                /* Alineación en línea */
                text-decoration: none;
                /* Quita el subrayado del enlace */
                box-shadow: inset 0 0 0 1px #000;
                /* Borde interno negro con ancho de 1px */
            }
    
            .iconoPerfil {
                font-size: 3em;
            }
    
            .tarjetica {
                float: left;
            }
    
            .colorBlack {
                color: black;
            }
    
            .subirform {
                margin-top: -12rem !important;
            }
    
            .loading-icon {
                font-size: 24px; // Ajusta el tamaño del ícono según tus preferencias
                animation: spin 2s linear infinite; // Agrega una animación de giro al ícono
            }
    
            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }
    
                100% {
                    transform: rotate(360deg);
                }
            }
    
            .opcionTajetaDrown {
                position: relative;
                top: -3.5em;
            }
        </style>
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"  ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.js" integrity="sha512-otOZr2EcknK9a5aa3BbMR9XOjYKtxxscwyRHN6zmdXuRfJ5uApkHB7cz1laWk2g8RKLzV9qv/fl3RPwfCuoxHQ==" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> -->
<script src="/js/global.js"></script> 
<script src="/js/empresas/empresas.js"></script> 

<script>
    document.querySelector("#profile-foreground-img-file-input") && document.querySelector("#profile-foreground-img-file-input").addEventListener("change", function() {
        var o = document.querySelector(".profile-wid-img")
        , e = document.querySelector(".profile-foreground-img-file-input").files[0]
        , i = new FileReader;
        i.addEventListener("load", function() {
            o.src = i.result
            console.log('llega');
        }, !1),
        e && i.readAsDataURL(e) 
    }),
    document.querySelector("#profile-img-file-input") && document.querySelector("#profile-img-file-input").addEventListener("change", function() {
        var o = document.querySelector(".user-profile-image")
        , e = document.querySelector(".profile-img-file-input").files[0]
        , i = new FileReader;
        i.addEventListener("load", function() {
            o.src = i.result
            console.log('llega 2');
            vue_empresas.GuardarFileEmpresa('nuevo');
        }, !1),
        e && i.readAsDataURL(e)
    });
    var count = 2;
    function new_link() {
        count++;
        var o = document.createElement("div")
        , e = '<div class="row"><div class="col-lg-12"><div class="mb-3"><label for="jobTitle1" class="form-label">Job Title</label><input type="text" class="form-control" id="jobTitle1" placeholder="Job title"></div></div><div class="col-lg-6"><div class="mb-3"><label for="companyName" class="form-label">Company Name</label><input type="text" class="form-control" id="companyName" placeholder="Company name"></div></div><div class="col-lg-6"><div class="mb-3"><label for="choices-single-default3" class="form-label">Experience Years</label><div class="row"><div class="col-lg-5"><select class="form-control" data-trigger name="choices-single-default3"> <option value="">Select years</option><option value="Choice 1">2001</option><option value="Choice 2">2002</option><option value="Choice 3">2003</option><option value="Choice 4">2004</option><option value="Choice 5">2005</option><option value="Choice 6">2006</option><option value="Choice 7">2007</option><option value="Choice 8">2008</option><option value="Choice 9">2009</option><option value="Choice 10">2010</option><option value="Choice 11">2011</option><option value="Choice 12">2012</option><option value="Choice 13">2013</option><option value="Choice 14">2014</option><option value="Choice 15">2015</option><option value="Choice 16">2016</option><option value="Choice 17">2017</option><option value="Choice 18">2018</option><option value="Choice 19">2019</option><option value="Choice 20">2020</option><option value="Choice 21">2021</option><option value="Choice 22">2022</option></select></div><div class="col-auto align-self-center">to</div><div class="col-lg-5"><select class="form-control" data-trigger  name="choices-single-default2"><option value="">Select years</option><option value="Choice 1">2001</option><option value="Choice 2">2002</option><option value="Choice 3">2003</option><option value="Choice 4">2004</option><option value="Choice 5">2005</option><option value="Choice 6">2006</option><option value="Choice 7">2007</option><option value="Choice 8">2008</option><option value="Choice 9">2009</option><option value="Choice 10">2010</option><option value="Choice 11">2011</option><option value="Choice 12">2012</option><option value="Choice 13">2013</option><option value="Choice 14">2014</option><option value="Choice 15">2015</option><option value="Choice 16">2016</option><option value="Choice 17">2017</option><option value="Choice 18">2018</option><option value="Choice 19">2019</option><option value="Choice 20">2020</option><option value="Choice 21">2021</option><option value="Choice 22">2022</option></select></div></div></div></div><div class="col-lg-12"><div class="mb-3"><label for="jobDescription" class="form-label">Job Description</label><textarea class="form-control" id="jobDescription" rows="3" placeholder="Enter description"></textarea></div></div><div class="hstack gap-2 justify-content-end"><a class="btn btn-success" href="javascript:deleteEl(' + (o.id = count) + ')">Delete</a></div></div>'
        , e = (o.innerHTML = document.getElementById("newForm").innerHTML + e,
        document.getElementById("newlink").appendChild(o),
        document.querySelectorAll("[data-trigger]"));
        Array.from(e).forEach(function(o) {
            new Choices(o,{
                placeholderValue: "This is a placeholder set in the config",
                searchPlaceholderValue: "This is a search placeholder",
                searchEnabled: !1
            })
        })
    }
    function deleteEl(o) {
        o = (d = document).getElementById(o);
        d.getElementById("newlink").removeChild(o)
    }

</script>
@stop
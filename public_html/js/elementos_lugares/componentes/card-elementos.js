// Componente para generar las lineas de campos para ingresar cantidad y medidas de un item.
Vue.component("componente-tarjeta", {
    data: function () {
        return {
            Tipouser: "",
        };
    },
    methods: {
        Mostrar(id) {
            var accion = "Ver";
            vue_lugares.Mostrar(id, accion);
        },
        Eliminar(id) {
            vue_lugares.Eliminar(id);
        },
        MostrarEditar(id) {
            var accion = "Editar";
            vue_lugares.MostrarEditar(id, accion);
        },
        formatear_numeros(n) {
            // console.log(n);
            return vue_global.formatear_numeros(n, 0, ",", ".");
        },
        mostrarPrimeros30Caracteres(texto) {
            if (texto == undefined || texto == null || texto == "") {
                return texto;
            }
            if (texto.length <= 10) {
                return texto; // La cadena es igual o más corta que 30 caracteres, no es necesario truncarla.
            } else {
                return texto.slice(0, 10) + "..."; // Si la cadena es más larga, muestra los primeros 30 caracteres y agrega "..." al final.
            }
        },
    },
    props: ["idui", "item"],
    computed: {
        idItemDetalle() {
            return this.idui;
        },
    },
    mounted() {},
    template: /* vue-html */ `
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-3">
        <div class="card" style="cursor: pointer;">
            <div class="card-body card-preoperacional">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 d-flex align-items-center" @click="Mostrar(item.id)">
                        <div class="avatar-lg rounded" style="width: 96px; height: 96px; overflow: hidden;">
                            <img
                                :src="item.url_imagen ? item.url_imagen : 'imagenes/imagen_por_defecto.jpg'"
                                alt=""
                                class="member-img img-fluid d-block rounded medidas-imagen"
                                style="width: 100%; height: 100%; object-fit: cover;"
                                />
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="row">
                            <div class="col-9" @click="Mostrar(item.id)">
                                <a>
                                    <h5 class="fs-16 mb-1" v-text="item.codigo"></h5>
                                </a>
                            </div>
                            <div class="col-2">
                                <div class="text-end dropdown tresPuntos align-items-center" style="position: relative;" >
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="marginsettings">
                                    <i class="ri-more-fill fs-17 colorBlack"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" >
                                        <li>
                                            <a class="dropdown-item edit-list"  @click="Mostrar(item.id)" >
                                            <i class="ri-pencil-line me-2 align-bottom text-muted"></i>Editar
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item remove-list" @click="Eliminar(item.id)">
                                            <i class="ri-delete-bin-5-line me-2 align-bottom text-muted"></i>Eliminar
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row" @click="Mostrar(item.id)">
                            <div class="row" @click="Mostrar(item.id)">
                                <div class="d-flex flex-wrap gap-0 align-items-center">
                                    <div class="col-12">
                                        <div class="text-muted mb-0" v-text="mostrarPrimeros30Caracteres(item.nombre)"></div>
                                        <div class="text-muted mb-0" v-text="mostrarPrimeros30Caracteres(item.descripcion)"></div>
                                        <div class="text-muted mb-0" v-text="item.valor? '$ '+item.valor:'$ '+0"></div>
                                    </div>                                 
                                </div>
                            </div>
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `,
});

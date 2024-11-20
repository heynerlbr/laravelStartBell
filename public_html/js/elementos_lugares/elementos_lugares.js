var vue_lugares = new Vue({
    el: "#app",
    data: {
        lugares: [],
        empresas: [],
        municipios: [],
        lugaresTabla: [],
        lugaresElementos: [],
        elementos_imagenes: [],
        elementos_reservas: [],
        reservables: [],
        registro: {
            id: "",
            id_lugar: "",
            nombre: "",
            numero_capacidad: "",
            hora_inicio_disponibilidad: "",
            hora_fin_disponibilidad: "",
            lunes: true,
            martes: true,
            miercoles: true,
            jueves: true,
            viernes: true,
            sabado: true,
            domingo: true,
            descripcion: "",
            fecha_crea: "",
            fecha_modifica: "",
            url_imagen: "",
            valor: "",
        },
        registroReserva: {},
        botonMostrar: "",

        id_lugar_global: "",
    },
    methods: {
        vaciarCampos() {
            // Obtener la fecha actual
            var currentDate = new Date();

            // Formatear la fecha en formato "YYYY-MM-DD"
            var formattedDate = currentDate.toISOString().split("T")[0];
            this.registro.id = "";
            this.registro.id_lugar = "";
            this.registro.nombre = "";
            this.registro.numero_capacidad = "";
            this.registro.hora_inicio_disponibilidad = "";
            this.registro.hora_fin_disponibilidad = "";
            this.registro.lunes = true;
            this.registro.martes = true;
            this.registro.miercoles = true;
            this.registro.jueves = true;
            this.registro.viernes = true;
            this.registro.sabado = true;
            this.registro.domingo = true;
            this.registro.descripcion = "";
            this.registro.valor = "";

            this.registro.fecha_crea = formattedDate;
            this.registro.fecha_modifica = "";
            this.registro.url_imagen = "";
            $("#sel_lugar").val(0).trigger("change");
            $("#sel_tipo_reservables").val(0).trigger("change");
        },
        Nuevo() {
            this.botonMostrar = "Nuevo";
            this.vaciarCampos();
            $(".accion").prop("disabled", false);
            $("#div_main").css("display", "none");
            $("#div_form").css("display", "");
            $(".select2").select2();
        },
        Crear() {
            var id_lugar = $("#sel_lugar").val();
            var id_reservable = $("#sel_tipo_reservables").val();
            if (id_lugar == 0 || id_lugar == "" || id_lugar == undefined) {
                Swal.fire({
                    icon: "warning",
                    title: "Alerta",
                    text: "Por favor seleccione lugar",
                    timer: 1500,
                });
                return false;
            }
            this.registro.id_lugar = id_lugar;
            this.registro.id_reservable = id_reservable;
            if (
                this.registro.nombre == 0 ||
                this.registro.nombre == "" ||
                this.registro.nombre == undefined
            ) {
                Swal.fire({
                    icon: "warning",
                    title: "Alerta",
                    text: "Por favor ingrese nombre",
                    timer: 1500,
                });
                return false;
            }
            if (
                this.registro.numero_capacidad == 0 ||
                this.registro.numero_capacidad == "" ||
                this.registro.numero_capacidad == undefined
            ) {
                Swal.fire({
                    icon: "warning",
                    title: "Alerta",
                    text: "Por favor ingrese numero capacidad",
                    timer: 1500,
                });
                return false;
            }
            if (
                this.registro.hora_inicio_disponibilidad == 0 ||
                this.registro.hora_inicio_disponibilidad == "" ||
                this.registro.hora_inicio_disponibilidad == undefined
            ) {
                Swal.fire({
                    icon: "warning",
                    title: "Alerta",
                    text: "Por favor ingrese hora inicio",
                    timer: 1500,
                });
                return false;
            }
            if (
                this.registro.hora_fin_disponibilidad == 0 ||
                this.registro.hora_fin_disponibilidad == "" ||
                this.registro.hora_fin_disponibilidad == undefined
            ) {
                Swal.fire({
                    icon: "warning",
                    title: "Alerta",
                    text: "Por favor ingrese hora fin",
                    timer: 1500,
                });
                return false;
            }
            if (
                this.registro.descripcion == 0 ||
                this.registro.descripcion == "" ||
                this.registro.descripcion == undefined
            ) {
                Swal.fire({
                    icon: "warning",
                    title: "Alerta",
                    text: "Por favor ingrese descripcion",
                    timer: 1500,
                });
                return false;
            }
            vue_global.ajax_peticion("CrearElemento", this.registro, [
                (respuesta) => {
                    Swal.fire({
                        icon: respuesta.Tipo,
                        title: respuesta.Titulo,
                        text: respuesta.Respuesta,
                        timer: 1500,
                    });
                    if (respuesta.Tipo == "success") {
                        this.CerrarModal();
                        this.vaciarCampos();
                        this.Listar();
                        this.volverMain();
                    }
                },
            ]);
        },
        Listar() {
            if ($.fn.dataTable.isDataTable("#table_elementos")) {
                // $('#table_ordenes').dataTable().fnClearTable();
                var tabla = $("#table_elementos").DataTable();
                tabla.destroy();
            }
            vue_global.ajax_peticion("ListarElementos", null, [
                (respuesta) => {
                    this.lugares = respuesta.lugares;
                    this.municipios = respuesta.municipios;
                    this.empresas = respuesta.empresas;
                    this.lugaresTabla = respuesta.lugaresTabla;
                    this.reservables = respuesta.reservables;
                    $("#table_elementos").css("visibility", "visible");
                    this.$nextTick(() => {
                        $("#table_elementos").DataTable({
                            destroy: true,
                            language: {
                                decimal: "",
                                emptyTable: "No hay información",
                                info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                                infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
                                infoFiltered:
                                    "(Filtrado de _MAX_ total entradas)",
                                infoPostFix: "",
                                thousands: ",",
                                lengthMenu: "Mostrar _MENU_ Entradas",
                                loadingRecords: "Cargando...",
                                processing: "Procesando...",
                                search: "Buscar:",
                                zeroRecords: "Sin resultados encontrados",
                                paginate: {
                                    first: "Primero",
                                    last: "Ultimo",
                                    next: "Siguiente",
                                    previous: "Anterior",
                                },
                            },
                        });
                    });
                },
            ]);
        },
        Mostrar(id, accion) {
            this.botonMostrar = "Mostrar";
            this.registro.id = id;
            vue_global.ajax_peticion("MostrarElemento", this.registro, [
                (respuesta) => {
                    $("#div_form").css("display", "");
                    $("#div_tarjetas").css("display", "none");
                    $("#div_main").css("display", "none");
                    this.registro = respuesta.elemento;
                    this.ListarReservas(respuesta.elemento.id);
                    $("#sel_lugar")
                        .val(respuesta.elemento.id_lugar)
                        .trigger("change");
                    $("#sel_tipo_reservables")
                        .val(respuesta.elemento.id_reservable)
                        .trigger("change");

                    this.ListarImagenesElemento();
                    $(".select2").select2();
                },
            ]);
        },
        Eliminar(id) {
            this.registro.id = id;
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger",
                },
                buttonsStyling: false,
            });
            swalWithBootstrapButtons
                .fire({
                    title: "¿Está seguro que desea eliminar este registro?",
                    text: "El registro se eliminara permanentemente",
                    icon: "warning",
                    showCancelButton: true,
                    showCloseButton: true,
                    confirmButtonText: "SI, eliminar!",
                    cancelButtonText: "No, cancelar!",
                    reverseButtons: true,
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        vue_global.ajax_peticion(
                            "EliminarElemento",
                            this.registro,
                            [
                                (respuesta) => {
                                    Swal.fire({
                                        icon: respuesta.Tipo,
                                        title: respuesta.Titulo,
                                        text: respuesta.Respuesta,
                                        timer: 1500,
                                    });
                                    if (respuesta.Tipo == "success") {
                                        this.Listar();

                                        this.MostrarElementosLugares(
                                            this.id_lugar_global
                                        );
                                    }
                                },
                            ]
                        );
                    }
                });
        },
        CerrarModal() {
            $("#exampleModal").modal("hide");
        },
        Actualizar() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger",
                },
                buttonsStyling: false,
            });
            swalWithBootstrapButtons
                .fire({
                    title: "¿Está seguro que desea actualizar este registro?",
                    text: "El registro se tomara los cambios",
                    icon: "warning",
                    showCancelButton: true,
                    showCloseButton: true,
                    confirmButtonText: "SI, actualizar!",
                    cancelButtonText: "No, cancelar!",
                    reverseButtons: true,
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        var id_lugar = $("#sel_lugar").val();
                        var id_reservable = $("#sel_tipo_reservables").val();
                        if (
                            id_lugar == 0 ||
                            id_lugar == "" ||
                            id_lugar == undefined
                        ) {
                            Swal.fire({
                                icon: "warning",
                                title: "Alerta",
                                text: "Por favor seleccione lugar",
                                timer: 1500,
                            });
                            return false;
                        }

                        this.registro.id_lugar = id_lugar;
                        this.registro.id_reservable = id_reservable;

                        if (
                            this.registro.nombre == 0 ||
                            this.registro.nombre == "" ||
                            this.registro.nombre == undefined
                        ) {
                            Swal.fire({
                                icon: "warning",
                                title: "Alerta",
                                text: "Por favor ingrese nombre",
                                timer: 1500,
                            });
                            return false;
                        }
                        if (
                            this.registro.numero_capacidad == 0 ||
                            this.registro.numero_capacidad == "" ||
                            this.registro.numero_capacidad == undefined
                        ) {
                            Swal.fire({
                                icon: "warning",
                                title: "Alerta",
                                text: "Por favor ingrese numero capacidad",
                                timer: 1500,
                            });
                            return false;
                        }
                        if (
                            this.registro.hora_inicio_disponibilidad == 0 ||
                            this.registro.hora_inicio_disponibilidad == "" ||
                            this.registro.hora_inicio_disponibilidad ==
                                undefined
                        ) {
                            Swal.fire({
                                icon: "warning",
                                title: "Alerta",
                                text: "Por favor ingrese hora inicio",
                                timer: 1500,
                            });
                            return false;
                        }
                        if (
                            this.registro.hora_fin_disponibilidad == 0 ||
                            this.registro.hora_fin_disponibilidad == "" ||
                            this.registro.hora_fin_disponibilidad == undefined
                        ) {
                            Swal.fire({
                                icon: "warning",
                                title: "Alerta",
                                text: "Por favor ingrese hora fin",
                                timer: 1500,
                            });
                            return false;
                        }
                        if (
                            this.registro.descripcion == 0 ||
                            this.registro.descripcion == "" ||
                            this.registro.descripcion == undefined
                        ) {
                            Swal.fire({
                                icon: "warning",
                                title: "Alerta",
                                text: "Por favor ingrese descripcion",
                                timer: 1500,
                            });
                            return false;
                        }
                        vue_global.ajax_peticion(
                            "ActualizarElemento",
                            this.registro,
                            [
                                (respuesta) => {
                                    Swal.fire({
                                        icon: respuesta.Tipo,
                                        title: respuesta.Titulo,
                                        text: respuesta.Respuesta,
                                        timer: 1500,
                                    });
                                    if (respuesta.Tipo == "success") {
                                        this.Listar();
                                        this.CerrarModal();
                                    }
                                },
                            ]
                        );
                    }
                });
        },
        MostrarElementosLugares(idLugar) {
            this.id_lugar_global = idLugar;
            var registro = {
                idLugar: idLugar,
            };
            vue_global.ajax_peticion("MostrarElementosLugares", registro, [
                (respuesta) => {
                    if (respuesta.Tipo == "success") {
                        this.lugaresElementos = respuesta.lugaresElementos;
                        $("#div_main").css("display", "none");
                        $("#div_form").css("display", "none");
                        $("#div_tarjetas").css("display", "");
                    }
                },
            ]);
        },
        volverTarjeta() {
            if (this.botonMostrar == "Nuevo") {
                this.botonMostrar = "";
                this.volverMain();
            } else {
                $("#div_form").css("display", "none");
                $("#div_main").css("display", "none");
                $("#div_tarjetas").css("display", "");
            }
        },
        volverMain() {
            $("#div_tarjetas").css("display", "none");
            $("#div_form").css("display", "none");
            $("#div_main").css("display", "");
        },
        SubirImagenElemento() {
            vue_global.ajax_archivo_peticion(
                "SubirImagenElemento",
                "txt_archivo",
                this.registro,
                [
                    (respuesta) => {
                        Swal.fire({
                            icon: respuesta.Tipo,
                            title: respuesta.Titulo,
                            text: respuesta.Respuesta,
                            timer: 1500,
                        });
                        if (respuesta.Tipo == "success") {
                            $("#txt_archivo").val("");
                            this.ListarImagenesElemento();
                        }
                    },
                ]
            );
        },
        ListarImagenesElemento() {
            vue_global.ajax_peticion("ListarImagenesElemento", this.registro, [
                (respuesta) => {
                    if (respuesta.Tipo == "success") {
                        this.elementos_imagenes = respuesta.elementos_imagenes;
                    }
                },
            ]);
        },
        EliminarImagenElemento(id) {
            var registro = {
                id: id,
            };
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger",
                },
                buttonsStyling: false,
            });
            swalWithBootstrapButtons
                .fire({
                    title: "¿Está seguro que desea eliminar este registro?",
                    text: "El registro se eliminara permanentemente",
                    icon: "warning",
                    showCancelButton: true,
                    showCloseButton: true,
                    confirmButtonText: "SI, eliminar!",
                    cancelButtonText: "No, cancelar!",
                    reverseButtons: true,
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        vue_global.ajax_peticion(
                            "EliminarImagenElemento",
                            registro,
                            [
                                (respuesta) => {
                                    Swal.fire({
                                        icon: respuesta.Tipo,
                                        title: respuesta.Titulo,
                                        text: respuesta.Respuesta,
                                        timer: 1500,
                                    });
                                    if (respuesta.Tipo == "success") {
                                        this.ListarImagenesElemento();
                                    }
                                },
                            ]
                        );
                    }
                });
        },
        MostrarArchivo(rutaUrl, extension) {
            // Verificar si es un archivo de imagen
            var esImagen = /\.(png|jpg|jpeg|gif|bmp|ico|svg|webp)$/i.test(
                rutaUrl
            );

            var esOffice = /\.(doc|docx|xls|xlsx|ppt|pptx)$/i.test(extension);
            // URL del visor de PDF de Google Docs
            var visorPdf = "https://docs.google.com/viewer?url=";
            // Si es una imagen o un archivo PDF, mostrarlo en el modal
            if (esImagen) {
                // Construir la URL completa
                var urlCompleta = rutaUrl;
                // var urlCompleta = "https://gofile.me/7iqzo/U7XXYeryJ";
                // var urlCompleta = "190.0.27.6/Skala/29-1024x896-1506774890_1700587614.jpg";
                // Establecer la URL en el iframe
                $("#frame_vale").attr("src", urlCompleta);
                $("#iframeModal").modal("show");
            } else if (esOffice) {
                // Construir la URL completa
                // var urlCompleta = visorPdf + rutaUrl;
                var urlCompleta =
                    visorPdf + "https://gofile.me/7iqzo/9jxdGtty4";
                // Establecer la URL en el iframe
                $("#frame_vale").attr("src", urlCompleta);
                $("#iframeModal").modal("show");
            } else if (extension.toLowerCase() === "pdf") {
                $("#frame_vale").attr("src", rutaUrl);
                $("#iframeModal").modal("show");
            } else {
                // Archivo no compatible, mostrar un mensaje de error
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "El tipo de archivo no es compatible.",
                });
            }
        },
        SeleccionarImagenPrincipal(id) {
            var self = this;
            var registro = {
                id: id,
            };
            vue_global.ajax_peticion("SeleccionarImagenPrincipal", registro, [
                (respuesta) => {
                    if (respuesta.Tipo == "success") {
                        console.log("paso", this.registro.id);
                        self.Mostrar(self.registro.id, "");
                    }
                },
            ]);
        },

        //reservas elementos
        ListarReservas(id) {
            var registro = { id_elemento: id };
            if ($.fn.dataTable.isDataTable("#table_elementos_reservas")) {
                // $('#table_ordenes').dataTable().fnClearTable();
                var tabla = $("#table_elementos_reservas").DataTable();
                tabla.destroy();
            }
            vue_global.ajax_peticion("ListarReservasElemento", registro, [
                (respuesta) => {
                    this.elementos_reservas = respuesta.elementos_reservas;

                    $("#table_elementos_reservas").css("visibility", "visible");
                    this.$nextTick(() => {
                        $("#table_elementos_reservas").DataTable({
                            destroy: true,
                            language: {
                                decimal: "",
                                emptyTable: "No hay información",
                                info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                                infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
                                infoFiltered:
                                    "(Filtrado de _MAX_ total entradas)",
                                infoPostFix: "",
                                thousands: ",",
                                lengthMenu: "Mostrar _MENU_ Entradas",
                                loadingRecords: "Cargando...",
                                processing: "Procesando...",
                                search: "Buscar:",
                                zeroRecords: "Sin resultados encontrados",
                                paginate: {
                                    first: "Primero",
                                    last: "Ultimo",
                                    next: "Siguiente",
                                    previous: "Anterior",
                                },
                            },
                        });
                    });
                },
            ]);
        },
        MostrarReserva(id) {
            // this.botonMostrar = "Mostrar";
            // this.registroReserva.id = id;
            var registro = {
                id: id,
            };
            vue_global.ajax_peticion("MostrarReserva", registro, [
                (respuesta) => {
                    $("#ModalReserva").modal("show");
                    this.registroReserva = respuesta.reserva;
                    this.registroReserva.id = respuesta.reserva.id;
                },
            ]);
        },
        EliminarReserva(id) {
            var registro = { id: id };
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger",
                },
                buttonsStyling: false,
            });
            swalWithBootstrapButtons
                .fire({
                    title: "¿Está seguro que desea eliminar este registro?",
                    text: "El registro se eliminara permanentemente",
                    icon: "warning",
                    showCancelButton: true,
                    showCloseButton: true,
                    confirmButtonText: "SI, eliminar!",
                    cancelButtonText: "No, cancelar!",
                    reverseButtons: true,
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        vue_global.ajax_peticion("EliminarReserva", registro, [
                            (respuesta) => {
                                Swal.fire({
                                    icon: respuesta.Tipo,
                                    title: respuesta.Titulo,
                                    text: respuesta.Respuesta,
                                });
                                if (respuesta.Tipo == "success") {
                                    this.ListarReservas(this.registro.id);
                                }
                            },
                        ]);
                    }
                });
        },
        ActualizarReserva() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger",
                },
                buttonsStyling: false,
            });
            swalWithBootstrapButtons
                .fire({
                    title: "¿Está seguro que desea actualizar este registro?",
                    text: "El registro se tomara los cambios",
                    icon: "warning",
                    showCancelButton: true,
                    showCloseButton: true,
                    confirmButtonText: "SI, actualizar!",
                    cancelButtonText: "No, cancelar!",
                    reverseButtons: true,
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        vue_global.ajax_peticion(
                            "ActualizarReserva",
                            this.registroReserva,
                            [
                                (respuesta) => {
                                    Swal.fire({
                                        icon: respuesta.Tipo,
                                        title: respuesta.Titulo,
                                        text: respuesta.Respuesta,
                                        timer: 1500,
                                    });

                                    if (respuesta.Tipo == "success") {
                                        $("#ModalReserva").modal("hide");
                                        this.ListarReservas(this.registro.id);
                                    }
                                    // this.CerrarModal();
                                },
                            ]
                        );
                    }
                });
        },
        CambiarEstadoReserva(id, estado) {
            // this.botonMostrar = "Mostrar";
            var registro = {
                id: id,
                estado: estado,
            };
            vue_global.ajax_peticion("CambiarEstadoReserva", registro, [
                (respuesta) => {
                    if (respuesta.Tipo == "success") {
                        this.ListarReservas(this.registro.id);
                    }
                },
            ]);
        },
    },
    /**
     * Mounted es lo PRIMERO que ocurre cuando se carga la pagina
     */
    mounted() {
        /**
         * Cuando se carga la pagina necesito recibir
         */
        this.Listar();
    },
});

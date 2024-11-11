function Principal() {
    GraficaBarras();
}
function GraficaBarras() {
    vue_global.ajax_peticion("graficaBarrasContadorXestado", null, [
        (respuesta) => {
            $("#txt_cantidad_anulado").html(0);
            $("#txt_cantidad_sin_aprobar").html(0);
            $("#txt_cantidad_con_orden").html(0);
            $("#txt_cantidad_creado").html(0);
            $("#txt_cantidad_facturado").html(0);
            $("#txt_cantidad_no_aprobado").html(0);
            $("#txt_cantidad_sin_orden").html(0);
            $("#txt_cantidad_terminado").html(0);

            $("#txt_cantidad_no_aprobado_valor").html(formatUSD(0));
            $("#txt_cantidad_anulado_valor").html(formatUSD(0));
            $("#txt_cantidad_sin_aprobar_valor").html(formatUSD(0));
            $("#txt_cantidad_sin_orden_valor").html(formatUSD(0));
            $("#txt_cantidad_con_orden_valor").html(formatUSD(0));
            $("#txt_cantidad_facturado_valor").html(formatUSD(0));
            $("#txt_cantidad_terminado_valor").html(formatUSD(0));
            $("#txt_cantidad_creado_valor").html(formatUSD(0));

            var valorporestado = respuesta.sumaValorTotal;

            valorporestado.forEach((element) => {
                switch (element["estado"]) {
                    case "ANULADO":
                        $("#txt_cantidad_anulado_valor").html(
                            formatUSD(element["valor"])
                        );
                        break;
                    case "CERRADO":
                        $("#txt_cantidad_sin_aprobar_valor").html(
                            formatUSD(element["valor"])
                        );
                        break;
                    case "CONORDEN":
                        $("#txt_cantidad_con_orden_valor").html(
                            formatUSD(element["valor"])
                        );
                        break;
                    case "CREADO":
                        $("#txt_cantidad_creado_valor").html(
                            formatUSD(element["valor"])
                        );
                        break;
                    case "FACTURADO":
                        $("#txt_cantidad_facturado_valor").html(
                            formatUSD(element["valor"])
                        );
                        break;
                    case "NO APROBADO":
                        $("#txt_cantidad_no_aprobado_valor").html(
                            formatUSD(element["valor"])
                        );
                        break;
                    case "SINORDEN":
                        $("#txt_cantidad_sin_orden_valor").html(
                            formatUSD(element["valor"])
                        );
                        break;
                    case "TERMINADO":
                        $("#txt_cantidad_terminado_valor").html(
                            formatUSD(element["valor"])
                        );
                        break;
                }
            });

            var valorTotal = respuesta.valorTotal;
            $("#txt_valor_total").html("" + formatUSD(valorTotal[0].total));
            var cantidades = respuesta.cantidad;
            cantidades.forEach((element) => {
                switch (element["name"]) {
                    case "ANULADO":
                        $("#txt_cantidad_anulado").html(element["data"]);

                        break;
                    case "CERRADO":
                        $("#txt_cantidad_sin_aprobar").html(element["data"]);

                        break;
                    case "CONORDEN":
                        $("#txt_cantidad_con_orden").html(element["data"]);

                        break;
                    case "CREADO":
                        $("#txt_cantidad_creado").html(element["data"]);

                        break;
                    case "FACTURADO":
                        $("#txt_cantidad_facturado").html(element["data"]);

                        break;
                    case "NO APROBADO":
                        $("#txt_cantidad_no_aprobado").html(element["data"]);

                        break;
                    case "SINORDEN":
                        $("#txt_cantidad_sin_orden").html(element["data"]);

                        break;
                    case "TERMINADO":
                        $("#txt_cantidad_terminado").html(element["data"]);

                        break;
                }
            });
            var options3 = {
                chart: {
                    height: 345,
                    type: "bar",
                    toolbar: {
                        show: !1,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        columnWidth: "30%",
                    },
                },
                colors: ["#9fc1fa"],
                dataLabels: {
                    enabled: !1,
                },
                stroke: {
                    show: !0,
                    width: 2,
                },
                series: [
                    {
                        name: "mes",
                        data: respuesta.arrayValorxMesPrueba,
                    },
                ],
                // labels: respuesta.categoriasMesValor,
                labels: [
                    "Ene",
                    "Feb",
                    "Mar",
                    "Abr",
                    "May",
                    "Jun",
                    "Jul",
                    "Ago",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dic",
                ],
                yaxis: {
                    labels: {
                        offsetX: -12,
                        offsetY: 0,
                    },
                },
                grid: {
                    borderColor: "#e0e6ed",
                    strokeDashArray: 3,
                    xaxis: {
                        lines: {
                            show: !1,
                        },
                    },
                    yaxis: {
                        lines: {
                            show: !0,
                        },
                    },
                },
                legend: {
                    show: !1,
                },
                tooltip: {
                    marker: {
                        show: !0,
                    },
                    x: {
                        show: !1,
                    },
                },
                yaxis: {
                    labels: {
                        formatter: function (e) {
                            return "" + formatUSD(e);
                        },
                    },
                },
                fill: {
                    opacity: 1,
                },
            };
            (chart3 = new ApexCharts(
                document.querySelector("#Revenu_Status"),
                options3
            )).render();
            var options4 = {
                chart: {
                    height: 345,
                    type: "bar",
                    toolbar: {
                        show: !1,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        columnWidth: "30%",
                    },
                },
                colors: ["#9fc1fa"],
                dataLabels: {
                    enabled: !1,
                },
                stroke: {
                    show: !0,
                    width: 2,
                },
                series: [
                    {
                        name: "Dia",
                        data: respuesta.arrayValorxDias,
                    },
                ],
                labels: [
                    "01",
                    "02",
                    "03",
                    "04",
                    "05",
                    "06",
                    "07",
                    "08",
                    "09",
                    "10",
                    "11",
                    "12",
                    "13",
                    "14",
                    "15",
                    "16",
                    "17",
                    "18",
                    "19",
                    "20",
                    "21",
                    "22",
                    "23",
                    "24",
                    "25",
                    "26",
                    "27",
                    "28",
                    "29",
                    "30",
                    "31",
                ],
                yaxis: {
                    labels: {
                        offsetX: -12,
                        offsetY: 0,
                    },
                },
                grid: {
                    borderColor: "#e0e6ed",
                    strokeDashArray: 3,
                    xaxis: {
                        lines: {
                            show: !1,
                        },
                    },
                    yaxis: {
                        lines: {
                            show: !0,
                        },
                    },
                },
                legend: {
                    show: !1,
                },
                tooltip: {
                    marker: {
                        show: !0,
                    },
                    x: {
                        show: !1,
                    },
                },
                yaxis: {
                    labels: {
                        formatter: function (e) {
                            return "" + formatUSD(e);
                        },
                    },
                },
                fill: {
                    opacity: 1,
                },
            };
            (chart4 = new ApexCharts(
                document.querySelector("#Revenu_dias_mes_actual"),
                options4
            )).render();
        },
    ]);
}
function formatUSD(num) {
    var num = parseFloat(num);
    if (new Intl.NumberFormat("de-DE").format(num) == "NaN") {
        num = 0;
    }
    return (
        "$ " +
        // Number(num)
        //   .toString()
        //    .replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")
        new Intl.NumberFormat("de-DE").format(num)
    );
}
function cambioGrafica(id) {
    switch (id) {
        case 1:
            $("#div_mes_grafica").hide();
            $("#div_grafica_facturado").show();
            break;
        case 2:
            $("#div_grafica_facturado").hide();
            $("#div_mes_grafica").show();
            $("#div_mes_grafica").css("visibility", "visible");
            break;
    }
}

var vue_marcas = new Vue({
    el: "#app",
    data: {
        hallazgos: [],
        placasSinPreoperacionales: [],
        NumConductores: [],
        Novedades: [],
        NumVehiculos: [],
        NumPreoperacionales: [],
        PlacasConPreperacionales: [],
    },
    methods: {
        HallazgosDasborad() {
            // this.marcas = [];
            // if ($.fn.dataTable.isDataTable("#table_marcas")) {
            //     var tabla = $("#table_marcas").DataTable();
            //     tabla.destroy();
            // }

            vue_global.ajax_peticion("HallazgosDasborad", null, [
                (respuesta) => {
                    this.hallazgos = respuesta.hallazgos;
                    this.placasSinPreoperacionales =
                        respuesta.placasSinPreoperacionales;
                    this.NumConductores = respuesta.NumConductores;
                    this.Novedades = respuesta.Novedades;
                    this.NumVehiculos = respuesta.NumVehiculos;
                    this.NumPreoperacionales = respuesta.NumPreoperacionales;
                    this.PlacasConPreperacionales =
                        respuesta.PlacasConPreperacionales;
                },
            ]);
        },
    },
    mounted() {
        this.HallazgosDasborad();
    },
});

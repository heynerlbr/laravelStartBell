Vue.component("comp-grafica-lineas", {
    data() {
        return {
            reservasPorMes: [12, 15, 10, 18, 20, 22, 25, 30, 40, 35, 30, 45],
            meses: [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre",
            ],
            chart: null,
        };
    },
    methods: {
        inicializarGrafico() {
            const ctx = document
                .getElementById("graficoLineas")
                .getContext("2d");
            this.chart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: this.meses,
                    datasets: [
                        {
                            label: "Reservas por mes",
                            data: this.reservasPorMes,
                            backgroundColor: "rgba(153, 102, 255, 0.2)",
                            borderColor: "rgba(153, 102, 255, 1)",
                            borderWidth: 1,
                            fill: true,
                        },
                    ],
                },
            });
        },
    },
    mounted() {
        this.inicializarGrafico();
    },
    template: `<canvas id="graficoLineas"></canvas>`,
});

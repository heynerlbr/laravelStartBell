Vue.component("comp-grafica-donut", {
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
                .getElementById("graficoDonut")
                .getContext("2d");
            this.chart = new Chart(ctx, {
                type: "doughnut",
                data: {
                    labels: this.meses,
                    datasets: [
                        {
                            label: "Reservas por mes",
                            data: this.reservasPorMes,
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.2)",
                                "rgba(54, 162, 235, 0.2)",
                                "rgba(255, 206, 86, 0.2)",
                                "rgba(75, 192, 192, 0.2)",
                                "rgba(153, 102, 255, 0.2)",
                                "rgba(255, 159, 64, 0.2)",
                            ],
                        },
                    ],
                },
            });
        },
    },
    mounted() {
        this.inicializarGrafico();
    },
    template: `<canvas id="graficoDonut"></canvas>`,
});

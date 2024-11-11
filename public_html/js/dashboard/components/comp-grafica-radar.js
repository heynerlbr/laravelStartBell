Vue.component("comp-grafica-radar", {
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
                .getElementById("graficoRadar")
                .getContext("2d");
            this.chart = new Chart(ctx, {
                type: "radar",
                data: {
                    labels: this.meses,
                    datasets: [
                        {
                            label: "Reservas por mes",
                            data: this.reservasPorMes,
                            backgroundColor: "rgba(255, 99, 132, 0.2)",
                            borderColor: "rgba(255, 99, 132, 1)",
                            borderWidth: 1,
                        },
                    ],
                },
            });
        },
    },
    mounted() {
        this.inicializarGrafico();
    },
    template: `<canvas id="graficoRadar"></canvas>`,
});

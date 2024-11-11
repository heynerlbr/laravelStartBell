Vue.component("comp-grafica-reservas", {
    data() {
        return {
            reservasPorMes: [12, 15, 10, 18, 20, 22, 25, 30, 40, 35, 30, 45], // Datos de ejemplo
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
                .getElementById("graficoReservas")
                .getContext("2d");
            this.chart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: this.meses,
                    datasets: [
                        {
                            label: "Reservas por mes",
                            data: this.reservasPorMes,
                            backgroundColor: "rgba(75, 192, 192, 0.2)",
                            borderColor: "rgba(75, 192, 192, 1)",
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        },
        actualizarDatos(nuevosDatos) {
            this.reservasPorMes = nuevosDatos;
            if (this.chart) {
                this.chart.data.datasets[0].data = nuevosDatos;
                this.chart.update();
            }
        },
    },
    mounted() {
        this.inicializarGrafico();
    },
    template: `
      <div>
        <canvas id="graficoReservas"></canvas>
      </div>
    `,
});

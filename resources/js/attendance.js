import ApexCharts from "apexcharts";

const jsonData = JSON.parse(document.getElementById("jsonatt").value);

const dates = Object.keys(jsonData.data.dates);

const asistenciasData = dates.map(
    (date) => jsonData.data.dates[date].asistencias
);
const faltasData = dates.map((date) => jsonData.data.dates[date].faltas);

new ApexCharts(document.getElementById("attendance"), {
    chart: {
        type: "area",
        id: "Gráfico de Asistencias",
        height: "100%",
    },
    dataLabels: {
        enabled: false,
    },
    legend: {
        fontSize: 12,
    },
    series: [
        {
            name: "Asistencias",
            data: asistenciasData,
        },
        {
            name: "Faltas",
            data: faltasData,
        },
    ],
    xaxis: {
        categories: dates,
    },
    yaxis: {
        labels: {
            formatter: function (val) {
                return Math.round(val);
            },
        },
    },
}).render();

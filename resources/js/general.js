import ApexCharts from "apexcharts";

const generalData = JSON.parse(document.getElementById("jsonG").value);

new ApexCharts(document.querySelector("#general"), {
    series: [
        {
            name: "Hombres",
            data: Object.values(generalData["data"]["hombres"]["edades"]),
        },
        {
            name: "Mujeres",
            data: Object.values(generalData["data"]["mujeres"]["edades"]),
        },
    ],
    chart: {
        type: "bar",
        stacked: true,
    },
    plotOptions: {
        bar: {
            horizontal: false,
            stacked: true,
        },
    },
    yaxis: {
        labels: {
            formatter: function (val) {
                return Math.round(val);
            },
        },
    },
    xaxis: {
        categories: Object.keys(generalData["data"]["hombres"]["edades"]),
    },
    dataLabels: {
        style: {
            colors: ["#000"],
        },
    },
}).render();

new ApexCharts(document.querySelector("#childs"), {
    series: [
        {
            name: "Mujeres",
            data: [
                generalData["data"]["mujeres"]["con_hijos"],
                generalData["data"]["mujeres"]["total"] -
                    generalData["data"]["mujeres"]["con_hijos"],
            ],
        },
        {
            name: "Hombres",
            data: [
                generalData["data"]["hombres"]["con_hijos"],
                generalData["data"]["hombres"]["total"] -
                    generalData["data"]["hombres"]["con_hijos"],
            ],
        },
    ],
    chart: {
        type: "bar",
        stacked: true,
    },
    plotOptions: {
        bar: {
            horizontal: true,
            stacked: true,
            dataLabels: {
                total: {
                    enabled: true,
                    style: {
                        fontWeight: 900,
                    },
                },
            },
        },
    },
    xaxis: {
        categories: ["Con", "Sin"],
    },
    dataLabels: {
        style: {
            colors: ["#000"],
        },
    },
}).render();

new ApexCharts(document.querySelector("#capacitaciones"), {
    series: [
        generalData.data.capacitaciones,
        100 - generalData.data.capacitaciones,
    ],
    chart: {
        type: "pie",
    },
    labels: ["Capacitados ", "No Capacitados"],
    legend: {
        position: "bottom",
    },
    dataLabels: {
        style: {
            colors: ["#000"],
        },
        dropShadow: {
            enabled: false,
        },
    },
}).render();

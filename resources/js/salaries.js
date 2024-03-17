import ApexCharts from "apexcharts";

const data = JSON.parse(document.getElementById("jsonS").value);

new ApexCharts(document.querySelector("#salaries"), {
    series: [
        {
            name: "Salario",
            data: data["data"]["puestos"].map((puesto) => puesto.salario),
        },
    ],
    chart: {
        type: "bar",
        height: "100%",
    },
    xaxis: {
        categories: data["data"]["puestos"].map((puesto) => puesto.puesto),
    },
    dataLabels: {
        style: {
            colors: ["#000"],
        },
    },
}).render();

import ApexCharts from "apexcharts";

const data = JSON.parse(document.getElementById("jsonR").value);

const categories = [];
const seriesData = {};

const motivosCats = [];
const motivosSeries = [];

const temp_array = [];

data.data.detalles.forEach((unidad, i) => {
    motivosSeries.push({
        name: unidad.unidad,
        data: structuredClone(temp_array),
    });

    unidad.motivos.forEach((motivo) => {
        if (motivo.motivo == null) {
            motivo.motivo = "Sin motivo";
        }

        const pos = motivosCats.indexOf(motivo.motivo);

        if (pos === -1) {
            motivosCats.push(motivo.motivo);
            temp_array.push(0);
            motivosSeries[i].data.push(motivo.total);
        } else {
            motivosSeries[i].data[pos] = motivo.total;
        }
    });
    unidad.puestos.forEach((puesto) => {
        if (!categories.includes(puesto.puesto)) {
            categories.push(puesto.puesto);
        }
        if (!seriesData[unidad.unidad]) {
            seriesData[unidad.unidad] = [];
        }
        seriesData[unidad.unidad].push(puesto.total);
    });
});

new ApexCharts(document.querySelector("#rotations"), {
    chart: {
        type: "bar",
        stacked: true,
    },
    xaxis: {
        categories: categories,
    },
    yaxis: {
        labels: {
            formatter: function (val) {
                return Math.round(val);
            },
        },
    },
    plotOptions: {
        bar: {
            horizontal: false,
            stacked: true,
        },
    },
    legend: {
        position: "top",
    },
    series: Object.keys(seriesData).map((unidad) => ({
        name: unidad,
        data: seriesData[unidad],
    })),
    dataLabels: {
        style: {
            colors: ["#000"],
        },
    },
}).render();

new ApexCharts(document.querySelector("#rotationsM"), {
    chart: {
        type: "bar",
        stacked: true,
    },
    xaxis: {
        categories: motivosCats,
    },
    yaxis: {
        labels: {
            formatter: function (val) {
                return Math.round(val);
            },
        },
    },
    plotOptions: {
        bar: {
            horizontal: false,
            stacked: true,
        },
    },
    legend: {
        position: "top",
    },
    series: motivosSeries,
    dataLabels: {
        style: {
            colors: ["#000"],
        },
    },
}).render();

const despidosPorUnidad = data.data.detalles.map((detalle) => {
    const unidad = detalle.unidad;
    const puestos = detalle.puestos.length;

    return { unidad, puestos };
});

new ApexCharts(document.querySelector("#rotationsUnit"), {
    chart: {
        type: "bar",
        width: "100%",
        animations: {
            enabled: true,
        },
    },
    xaxis: {
        categories: despidosPorUnidad.map((item) => item.unidad),
    },
    yaxis: {
        labels: {
            formatter: function (val) {
                return Math.round(val);
            },
        },
    },
    series: [
        {
            data: despidosPorUnidad.map((item) => item.puestos),
        },
    ],
    dataLabels: {
        style: {
            colors: ["#000"],
        },
    },
}).render();

function DisplayDonut(id) {
    new ApexCharts(document.querySelector(`#${id}`), {
        series: [data.data[id], 100 - data.data[id]],
        labels: ["Si", "No"],
        chart: {
            type: "donut",
        },
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
}

DisplayDonut("firmas");
DisplayDonut("finiquitos");
DisplayDonut("entrevistas");
DisplayDonut("recontratables");

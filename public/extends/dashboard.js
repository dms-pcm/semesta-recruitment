jQuery(document).ready(function () {
    countRect();
    countUser();
    chart();
    rektNew();
    getTitle();
    $("#nav-dashboard").removeClass("collapsed");
});

function countRect() {
    $.ajax({
        url: `${urlApi}dashboard/countRect`,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        success: function (response) {
            $("#countRect").html(
                response?.data +
                    `<span class="text-muted small pt-2 ps-1" style="font-size:18px">rekrutmen</span>`
            );
        },
        error: function (xhr) {
            // handleErrorSimpan(xhr);
        },
    });
}

function countUser() {
    $.ajax({
        url: `${urlApi}dashboard/countUser`,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        success: function (response) {
            $("#countUser").html(
                response?.data +
                    `<span class="text-muted small pt-2 ps-1" style="font-size:18px">user</span>`
            );
        },
        error: function (xhr) {
            handleErrorSimpan(xhr);
        },
    });
}

function chart() {
    $.ajax({
        url: `${urlApi}dashboard/chart`,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        success: function (response) {
            let res = response?.data;
            if (res?.all == 0 && res?.no == 0 && res?.yes == 0) {
                $("#chart").addClass("d-none");
                $("#empty").removeClass("d-none");
            } else {
                $("#chart").removeClass("d-none");
                $("#empty").addClass("d-none");
                var labels = [
                    "Total Peserta",
                    "Peserta Tidak Lolos",
                    "Peserta Lolos",
                ];
                var values = [];
                for (var i in res) {
                    values.push(res[i]);
                }

                function getRandomColor() {
                    var letters = "0123456789ABCDEF";
                    var color = "#";
                    for (var i = 0; i < 6; i++) {
                        color += letters[Math.floor(Math.random() * 16)];
                    }
                    return color;
                }

                var backgroundColors = [];
                for (var i = 0; i < labels.length; i++) {
                    backgroundColors.push(getRandomColor());
                }

                // var ctx = document.getElementById("myChart").getContext("2d");
                // var myChart = new Chart(ctx, {
                //     type: "doughnut",
                //     data: {
                //         labels: labels,
                //         datasets: [
                //             {
                //                 label: "My First Dataset",
                //                 data: values,
                //                 backgroundColor: backgroundColors,
                //                 hoverOffset: 4,
                //             },
                //         ],
                //     },
                // });

                var options = {
                    series: values,
                    chart: {
                        type: "donut",
                    },
                    labels: labels,
                    colors: backgroundColors,
                    legend: {
                        position: "bottom",
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: "45%",
                            },
                        },
                    },
                    responsive: [
                        {
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 200,
                                },
                            },
                        },
                    ],
                };

                var chart = new ApexCharts(
                    document.querySelector("#myChart"),
                    options
                );
                chart.render();
            }
        },
    });
}

function rektNew() {
    $.ajax({
        url: `${urlApi}dashboard/newRekt`,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        success: function (response) {
            let res = response?.data;
            let html = ``;
            if (res == "") {
                $("#empty-data").removeClass("d-none");
            } else {
                $("#empty-data").addClass("d-none");
                for (let i = 0; i < 3; i++) {
                    if (res[i]?.description != undefined) {
                        let result =
                            res[i]?.description.length > 73
                                ? res[i]?.description.slice(0, 73) + "..."
                                : res[i]?.description;
                        html += `
                        <div class="post-item clearfix">
                            <img src="${baseUrl}storage/${res[i]?.attachment}" alt="${res[i]?.title}">
                            <h4><a>${res[i]?.title}</a></h4>
                            <p>${result}</p>
                        </div>
                        `;
                    }
                }
                $("#content-body").html(html);
            }
        },
        error: function (xhr) {
            // handleErrorSimpan(xhr);
        },
    });
}

function getTitle() {
    $.ajax({
        url: `${urlApi}participants/title`,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        async: true,
        cache: false,
        success: function (response) {
            $.each(response?.data, function (index, element) {
                $("#inputFilter").append(
                    '<option value="' +
                        element?.id +
                        '">' +
                        element?.title +
                        "</option>"
                );
                $(".selectpicker").selectpicker("refresh");
            });
        },
        error: function (xhr) {
            // handleErrorTable(xhr);
        },
    });
}

// var ctx = document.getElementById("myGrafik").getContext("2d");
// var myChart = null; // Variable to hold the chart object

// function createChart(labels, datasets) {
//     return new Chart(ctx, {
//         type: "bar",
//         data: {
//             labels: labels,
//             datasets: datasets,
//         },
//     });
// }

// function destroyChart() {
//     if (myChart) {
//         myChart.destroy();
//         myChart = null;
//     }
// }

function show() {
    if ($("#inputFilter").val() == "") {
        Swal.fire({
            title: "Oopss...",
            icon: "warning",
            text: "Silahkan pilih rekrutmen terlebih dahulu",
            allowOutsideClick: false,
        });
    } else {
        $.ajax({
            url: `${urlApi}dashboard/grafik`,
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
            data: {
                rektID: $("#inputFilter").val(),
            },
            success: function (response) {
                let res = response?.data;
                $("#grafik").removeClass("d-none");
                $("#selectRekrutmen").addClass("d-none");
                var labels = [
                    "Total Peserta",
                    "Peserta Tidak Lolos",
                    "Peserta Lolos",
                ];
                var value = [];
                for (var i in res) {
                    value.push(res[i]);
                }
                // var datasets = [];
                var backgroundColors = [];
                function getRandomColor() {
                    var letters = "0123456789ABCDEF";
                    var color = "#";
                    for (var i = 0; i < 6; i++) {
                        color += letters[Math.floor(Math.random() * 16)];
                    }
                    return color;
                }

                for (var i = 0; i < labels.length; i++) {
                    backgroundColors.push(getRandomColor());
                }
                // destroyChart(); // Destroy the previous chart, if any
                // for (var i = 0; i < labels.length; i++) {
                //     var dataset = {
                //         label: labels[i],
                //         data: [],
                //         backgroundColor: [],
                //         hoverOffset: 4,
                //     };
                //     for (var j = 0; j < value.length; j++) {
                //         if (i == j) {
                //             dataset.data.push(value[j]);
                //             dataset.backgroundColor.push(getRandomColor());
                //         } else {
                //             dataset.data.push(0);
                //             dataset.backgroundColor.push("transparent");
                //         }
                //     }
                //     datasets.push(dataset);
                // }
                // myChart = createChart(labels, datasets); // Create the new chart

                var options = {
                    series: [
                        {
                            data: value,
                        },
                    ],
                    chart: {
                        height: 350,
                        type: "bar",
                        events: {
                            click: function (chart, w, e) {
                                // console.log(chart, w, e)
                            },
                        },
                    },
                    colors: backgroundColors,
                    plotOptions: {
                        bar: {
                            columnWidth: "45%",
                            distributed: true,
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    legend: {
                        show: false,
                    },
                    labels: labels,
                    tooltip: {
                        y: {
                            formatter: function (
                                value,
                                { series, seriesIndex, dataPointIndex, w }
                            ) {
                                return value;
                            },
                            title: {
                                formatter: function (
                                    value,
                                    { series, seriesIndex, dataPointIndex, w }
                                ) {
                                    return `${w?.globals?.labels[dataPointIndex]} :`;
                                },
                            },
                        },
                    },
                };

                var chart = new ApexCharts(
                    document.querySelector("#myGrafik"),
                    options
                );
                chart.render();
                chart.updateSeries(options.series);
            },
        });
    }
}

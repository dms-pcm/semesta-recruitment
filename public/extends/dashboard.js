jQuery(document).ready(function () {
    countRect();
    countUser();
    chart();
    rektNew();
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
            handleErrorSimpan(xhr);
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
                    // labels.push(data[i].label);
                    values.push(res[i]);
                }
                var ctx = document.getElementById("myChart").getContext("2d");
                var myChart = new Chart(ctx, {
                    type: "doughnut",
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: "My First Dataset",
                                data: values,
                                backgroundColor: [
                                    "rgb(54, 162, 235)",
                                    "rgb(255, 99, 132)",
                                    "rgb(103, 255, 86)",
                                ],
                                hoverOffset: 4,
                                // borderColor: [
                                //     "rgba(255, 99, 132, 1)",
                                //     "rgba(54, 162, 235, 1)",
                                //     "rgba(255, 206, 86, 1)",
                                // ],
                                // borderWidth: 1,
                            },
                        ],
                    },
                });
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
                for (let i = 0; i < 5; i++) {
                    if (res[i]?.description != undefined) {
                        let result =
                            res[i]?.description.length > 73
                                ? res[i]?.description.slice(0, 73) + "..."
                                : res[i]?.description;
                        html += `
                        <div class="post-item clearfix">
                            <img src="${baseUrl}storage/${res[i]?.attachment}" style="object-fit: cover;height:80px;" alt="${res[i]?.title}">
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
            handleErrorSimpan(xhr);
        },
    });
}

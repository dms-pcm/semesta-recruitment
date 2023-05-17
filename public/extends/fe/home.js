jQuery(document).ready(function () {
    showRekt();
    var currentPage = window.location.href;

    if (currentPage === baseUrl || currentPage === baseUrl + "#hero") {
        $("#nav-home").addClass("active");
        $("#nav-info").removeClass("active");
    } else if (currentPage === baseUrl + "#about") {
        $("#nav-about").addClass("active");
        $("#nav-info").removeClass("active");
    }

    $("#nav-home").on("click", function () {
        $("#nav-home").addClass("active");
        $("#nav-about").removeClass("active");
        $("#nav-info").removeClass("active");
    });

    $("#nav-about").on("click", function () {
        $("#nav-home").removeClass("active");
        $("#nav-about").addClass("active");
        $("#nav-info").removeClass("active");
    });
});

function loadStart() {
    $(".loader").css("display", "flex");
}

function loadStop() {
    $(".loader").css("display", "none");
}

function showRekt() {
    // loadStart();
    $.ajax({
        url: `${urlApi}show`,
        type: "GET",
        // headers: {
        //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        //     Authorization: "Bearer " + localStorage.getItem("token"),
        // },
        success: function (response) {
            // loadStop();
            let html = ``;
            let res = response?.data;
            for (let i = 0; i < 6; i++) {
                let data = res[i]?.description;
                if (data != undefined) {
                    let result =
                        data.length > 125 ? data.slice(0, 125) + "..." : data;
                    html += `
                    <div class="col-lg-4 col-md-6" data-aos="fade-up">
                        <div class="card">
                            <div class="card-img">
                                <img src="${baseUrl}storage/${res[i]?.attachment}" data-fancybox data-caption="Flayer ${res[i]?.title}" alt="" class="img-fluid" style="cursor:pointer;height: 20rem;width: 100%;object-fit: cover;">
                            </div>
                            <h3><a href="javascript:void(0)" class="">${res[i]?.title}</a></h3>
                            <p class="deskripsi-loker">${result}</p>
                            <div style="padding: 0 30px;">
                                <a href="javascript:void(0)" onclick="detail(${res[i]?.id})" class="btn float-end btn-detail-rekrutmen text-white" style="margin-bottom:30px;background-color: white;border-color:#ffc107;">Detail</a>
                            </div>
                        </div>
                    </div>
                    `;
                }
            }
            $("#info-rekt").html(html);

            if ($(".btn-detail-rekrutmen").length >= 6) {
                $("#row-btn-view-all").removeClass("d-none");
            } else {
                $("#row-btn-view-all").addClass("d-none");
            }
        },
        error: function (xhr) {
            // loadStop();
            if (xhr.status == 422) {
                $("#row-btn-view-all").addClass("d-none");
                $("#nothing").removeClass("d-none");
            } else {
                // $("#row-btn-view-all").removeClass("d-none");
                $("#nothing").addClass("d-none");
            }
            // handleErrorSimpan(xhr);
        },
    });
}

function detail(id) {
    window.location.replace(`${baseUrl}detail-information?=${id}`);
}

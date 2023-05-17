jQuery(document).ready(function () {
    showAll();
    var currentPage = window.location.href;
    if (currentPage === document.URL) {
        $("#nav-info").addClass("active");
    }
    $("#nav-info").on("click", function () {
        $("#nav-info").addClass("active");
        $("#nav-home").removeClass("active");
        $("#nav-about").removeClass("active");
    });
});

function loadStart() {
    $(".loader").css("display", "flex");
}

function loadStop() {
    $(".loader").css("display", "none");
}

function showAll() {
    $.ajax({
        url: `${urlApi}show`,
        type: "GET",
        // headers: {
        //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        //     Authorization: "Bearer " + localStorage.getItem("token"),
        // },
        success: function (response) {
            let html = ``;
            $.each(response?.data, function (index, element) {
                let data = element?.description;
                let result =
                    data.length > 125 ? data.slice(0, 125) + "..." : data;
                html += `
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="card">
                        <div class="card-img">
                            <img src="${baseUrl}storage/${element?.attachment}" data-fancybox data-caption="Flayer" alt="" class="img-fluid" style="cursor:pointer;height: 20rem;width: 100%;object-fit: cover;">
                        </div>
                        <h3><a href="javascript:void(0)" class="">${element?.title}</a></h3>
                        <p class="deskripsi-loker">${result}</p>
                        <div style="padding: 0 30px;">
                            <a href="javascript:void(0)" onclick="detail(${element?.id})" class="btn float-end btn-detail-rekrutmen text-white" style="margin-bottom:30px;background-color: white;border-color:#ffc107;">Detail</a>
                        </div>
                    </div>
                </div>
                `;
            });
            $("#all-information").html(html);
        },
        error: function (xhr) {
            if (xhr.status == 422) {
                $("#nothing").removeClass("d-none");
            } else {
                $("#nothing").addClass("d-none");
            }
            // handleErrorSimpan(xhr);
        },
    });
}

function detail(id) {
    window.location.replace(`${baseUrl}detail-information?=${id}`);
}

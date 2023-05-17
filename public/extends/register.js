jQuery(document).ready(function () {});

function loadStart() {
    $(".loader").css("display", "flex");
}

function loadStop() {
    $(".loader").css("display", "none");
}

function preventStart() {
    $(".button-prevent").removeClass("d-none");
    $(".button-initial").addClass("d-none");
}

function preventStop(params) {
    $(".button-initial").removeClass("d-none");
    $(".button-prevent").addClass("d-none");
}

function register() {
    loadStart();
    preventStart();
    $.ajax({
        url: `${urlApi}register`,
        type: "POST",
        data: {
            full_name: $("#yourName").val(),
            email: $("#yourEmail").val(),
            username: $("#yourUsername").val(),
            password: $("#yourPassword").val(),
        },
        success: function (response) {
            let res = response?.status;
            setTimeout(function () {
                loadStop();
                preventStop();
                Swal.fire({
                    icon: "success",
                    title: "Berhasil !",
                    text: res?.message,
                }).then((result) => {
                    window.location = `${baseUrl}login`;
                });
            }, 1500);
        },
        error: function (xhr) {
            setTimeout(function () {
                loadStop();
                preventStop();
                handleErrorSimpan(xhr);
                // window.location = `${baseUrl}register`;
            }, 1500);
        },
    });
}

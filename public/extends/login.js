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

function login() {
    loadStart();
    preventStart();
    $.ajax({
        url: `${urlApi}login`,
        type: "POST",
        data: {
            username: $("#yourUsername").val(),
            password: $("#yourPassword").val(),
        },
        success: function (response) {
            setTimeout(function () {
                loadStop();
                preventStop();
                if (localStorage.getItem("role") == 1) {
                    window.location = `${baseUrl}be-admin/dashboard`;
                } else {
                    // Swal.fire({
                    //     icon: "warning",
                    //     title: "Oops...",
                    //     text: "Anda tidak memiliki akses !",
                    // }).then((result) => {
                    // });
                    window.location = `${baseUrl}`;
                    // localStorage.clear();
                    // localStorage.setItem("token", " ");
                    // localStorage.setItem("user", " ");
                    // localStorage.setItem("role", " ");
                    // localStorage.setItem("name", " ");
                    // localStorage.setItem("type-role", " ");
                }
            }, 1500);
            let res = response?.data;
            localStorage.setItem("token", res?.token?.original?.access_token);
            localStorage.setItem("user", res?.user?.id);
            localStorage.setItem("role", res?.user?.role?.id);
            localStorage.setItem("name", res?.user?.full_name);
            localStorage.setItem("type-role", res?.user?.role?.role);
        },
        error: function (xhr) {
            setTimeout(function () {
                loadStop();
                preventStop();
                handleErrorLogin(xhr);
            }, 1500);
        },
    });
}

function logout() {
    loadStart();
    $.ajax({
        url: `${urlApi}logout`,
        type: "POST",
        headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        success: function (response) {
            setTimeout(function () {
                loadStop();
                window.location = `${baseUrl}login`;
            }, 1500);
            let res = response?.data;
            localStorage.clear();
            delete localStorage.token;
            delete localStorage.user;
            delete localStorage.role;
            delete localStorage.name;
            localStorage.removeItem("type-role");
            // localStorage.setItem("token", " ");
            // localStorage.setItem("user", " ");
            // localStorage.setItem("role", " ");
            // localStorage.setItem("name", " ");
            // localStorage.setItem("type-role", " ");
        },
        error: function (xhr) {
            setTimeout(function () {
                loadStop();
                handleErrorLogin(xhr);
            }, 1500);
        },
    });
}

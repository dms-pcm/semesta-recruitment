jQuery(document).ready(function () {
    showInput();
    preview();
});

function loadStart() {
    $(".loader").css("display", "flex");
}

function loadStop() {
    $(".loader").css("display", "none");
}

function preview() {
    foto_profile.onchange = (evt) => {
        const [file] = foto_profile.files;
        if (file) {
            prev.src = URL.createObjectURL(file);
            blah.src = URL.createObjectURL(file);
        }
    };
}

function showInput() {
    $.ajax({
        url: `${urlApi}profile`,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        success: function (response) {
            let res = response?.data[0];
            if (res?.attachment != null) {
                $("#prev").attr("src", `${baseUrl}storage/${res?.attachment}`);
                $("#blah").attr("src", `${baseUrl}storage/${res?.attachment}`);
            } else {
                $("#prev").attr(
                    "src",
                    `${baseUrl}be/assets/img/default-profile.jpg`
                );
                $("#blah").attr(
                    "src",
                    `${baseUrl}be/assets/img/default-profile.jpg`
                );
            }

            $("#input-fullName").val(res?.full_name);
            $("#input-Country").val(res?.country);
            $("#input-Address").val(res?.address);
            $("#input-Phone").val(res?.phone);
            $("#input-Email").val(res?.email);
            if (res?.twitter != null) {
                $("#tw").attr("href", res?.twitter);
                $("#tw").attr("target", "_blank");
            } else {
                $("#tw").attr("href", "javascript:void(0)");
            }
            if (res?.facebook != null) {
                $("#fb").attr("href", res?.facebook);
                $("#fb").attr("target", "_blank");
            } else {
                $("#fb").attr("href", "javascript:void(0)");
            }
            if (res?.instagram != null) {
                $("#ig").attr("href", res?.instagram);
                $("#ig").attr("target", "_blank");
            } else {
                $("#ig").attr("href", "javascript:void(0)");
            }
            $("#input-Twitter").val(res?.twitter);
            $("#input-Facebook").val(res?.facebook);
            $("#input-Instagram").val(res?.instagram);

            if (res?.full_name != null) {
                $("#name").text(res?.full_name);
                $("#fullName").text(res?.full_name);
            } else {
                $("#name").html(
                    `<span class="badge bg-warning">Belum dimasukkan</span>`
                );
                $("#fullName").html(
                    `<span class="badge bg-warning">Belum dimasukkan</span>`
                );
            }
            if (res?.email != null) {
                $("#sahaan").text(res?.email);
            } else {
                $("#sahaan").html(
                    `<span class="badge bg-warning">Belum dimasukkan</span>`
                );
            }
            if (res?.country != null) {
                $("#Country").text(res?.country);
            } else {
                $("#Country").html(
                    `<span class="badge bg-warning">Belum dimasukkan</span>`
                );
            }
            if (res?.address != null) {
                $("#Address").text(res?.address);
            } else {
                $("#Address").html(
                    `<span class="badge bg-warning">Belum dimasukkan</span>`
                );
            }
            if (res?.phone != null) {
                $("#Phone").text(res?.phone);
            } else {
                $("#Phone").html(
                    `<span class="badge bg-warning">Belum dimasukkan</span>`
                );
            }
            if (res?.email != null) {
                $("#Email").text(res?.email);
            } else {
                $("#Email").html(
                    `<span class="badge bg-warning">Belum dimasukkan</span>`
                );
            }

            if (res?.cv != null) {
                $("#row-exits-cv").removeClass("d-none");
                $("#name-file").text(res?.originalName);
            } else {
                $("#row-exits-cv").addClass("d-none");
                $("#name-file").text("");
            }
        },
        error: function (xhr) {
            handleErrorSimpan(xhr);
        },
    });
}

function ubah() {
    var formData = new FormData();
    if ($("input[type='file']")[0].files[0] == undefined) {
        formData.append("full_name", $("#input-fullName").val());
        formData.append("country", $("#input-Country").val());
        formData.append("address", $("#input-Address").val());
        formData.append("phone", $("#input-Phone").val());
        formData.append("email", $("#input-Email").val());
        formData.append("twitter", $("#input-Twitter").val());
        formData.append("facebook", $("#input-Facebook").val());
        formData.append("instagram", $("#input-Instagram").val());
    } else {
        formData.append("attachment", $("input[type='file']")[0].files[0]);
        formData.append("full_name", $("#input-fullName").val());
        formData.append("country", $("#input-Country").val());
        formData.append("address", $("#input-Address").val());
        formData.append("phone", $("#input-Phone").val());
        formData.append("email", $("#input-Email").val());
        formData.append("twitter", $("#input-Twitter").val());
        formData.append("facebook", $("#input-Facebook").val());
        formData.append("instagram", $("#input-Instagram").val());
    }

    loadStart();
    $.ajax({
        url: `${urlApi}profile/update-profile/${localStorage.getItem("user")}`,
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            setTimeout(function () {
                loadStop();
                Swal.fire({
                    title: "Berhasil!",
                    text: response.status.message,
                    icon: "success",
                    allowOutsideClick: false,
                }).then((result) => {
                    window.location = `${baseUrl}profile`;
                });
            }, 1000);
        },
        error: function (xhr) {
            setTimeout(function () {
                loadStop();
                handleErrorSimpan(xhr);
            }, 1000);
        },
    });
}

function hapus() {
    Swal.fire({
        title: "Hapus Foto Profile?",
        text: "Apakah anda yakin ingin menghapus foto profile ini!",
        icon: "warning",
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#acacac",
        cancelButtonText: "Batal",
        confirmButtonText: "Iya, Hapus",
    }).then((result) => {
        if (result.isConfirmed) {
            loadStart();
            $.ajax({
                url: `${urlApi}profile/delete-picture/${localStorage.getItem(
                    "user"
                )}`,
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
                success: function (response) {
                    setTimeout(function () {
                        loadStop();
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.status.message,
                            icon: "success",
                            allowOutsideClick: false,
                        }).then((result) => {
                            window.location = `${baseUrl}profile`;
                        });
                    }, 1000);
                },
                error: function (xhr) {
                    setTimeout(function () {
                        loadStop();
                        handleErrorSimpan(xhr);
                    }, 1000);
                },
            });
        }
    });
}

function ubahPassword() {
    loadStart();
    $.ajax({
        url: `${urlApi}profile/change-password`,
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        data: {
            current_password: $("#currentPassword").val(),
            new_password: $("#newPassword").val(),
            new_confirm_password: $("#renewPassword").val(),
        },
        success: function (response) {
            setTimeout(function () {
                loadStop();
                Swal.fire({
                    title: "Berhasil!",
                    text: response.status.message,
                    icon: "success",
                    allowOutsideClick: false,
                }).then((result) => {
                    window.location = `${baseUrl}profile`;
                });
            }, 1000);
        },
        error: function (xhr) {
            setTimeout(function () {
                loadStop();
                handleErrorSimpan(xhr);
            }, 1000);
        },
    });
}

function uploadCV() {
    var formData = new FormData(document.getElementById("form-cv"));
    if ($("#form-cv input[type='file']")[0].files[0] == undefined) {
        // formData.append("cv", "");
    } else {
        formData.append("cv", $("#form-cv input[type='file']")[0].files[0]);
    }
    loadStart();
    $.ajax({
        url: `${urlApi}profile/upload-cv`,
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            setTimeout(function () {
                loadStop();
                Swal.fire({
                    title: "Berhasil!",
                    text: response.status.message,
                    icon: "success",
                    allowOutsideClick: false,
                }).then((result) => {
                    window.location = `${baseUrl}profile`;
                });
            }, 1000);
        },
        error: function (xhr) {
            setTimeout(function () {
                loadStop();
                handleErrorSimpan(xhr);
            }, 1000);
        },
    });
}

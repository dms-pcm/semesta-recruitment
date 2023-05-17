jQuery(document).ready(function () {
    $("#nav-persyaratan").removeClass("collapsed");
    showTable();
    $("#inputTipe").on("change", function () {
        if ($("#inputTipe").val() == "file") {
            $("#row-format").removeClass("d-none");
        } else {
            $("#row-format").addClass("d-none");
        }
    });
});

function loadStart() {
    $(".loader").css("display", "flex");
}

function loadStop() {
    $(".loader").css("display", "none");
}

function tutup() {
    $("#buatSyarat").modal("hide");
    $("#buatSyarat #inputPersyaratan").val("");
    $("#buatSyarat #inputTipe").val("");
    $("#buatSyarat #inputFormat").val("");
    $(".selectpicker").selectpicker("refresh");
}

function showTable() {
    $("#tbl-persyaratan").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        language: {
            zeroRecords: "Tidak ditemukan data yang cocok",
            oPaginate: {
                sPrevious: "<span aria-hidden='true'>«</span>",
                sNext: "<span aria-hidden='true'>»</span>",
            },
        },
        ajax: {
            url: `${urlApi}persyaratan`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
            async: true,
            dataSrc: function (json) {
                data = json?.data;
                return json.data;
            },
            error: function (xhr, error, code) {
                $("#tbl-rekrutmen_processing").addClass("d-none");
                let html = `
                    <tr class="odd"><td colspan="5" class="dataTables_empty" valign="top">Tidak ditemukan data yang cocok</td></tr>
                `;
                $("#tbl-rekrutmen tbody").html(html);
                handleErrorTable(xhr);
            },
        },
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
            },
            {
                data: "syarat",
                name: "syarat",
            },
            {
                data: "type",
                name: "type",
            },
            {
                data: "format",
                render: function (data, type, row) {
                    if (data == null) {
                        return `<span class="badge bg-info text-dark fs-6"><i class="bi bi-dash"></i></span>`;
                    } else {
                        return data;
                    }
                },
            },
            {
                data: "action",
                name: "action",
                orderable: true,
                searchable: true,
            },
        ],
    });
}

function tambahSyarat() {
    var formData = new FormData();
    formData.append("persyaratan", $("#inputPersyaratan").val());
    formData.append("type", $("#inputTipe").val());
    formData.append("format", $("#inputFormat").val());

    loadStart();
    $.ajax({
        url: `${urlApi}persyaratan/store`,
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
                    window.location = `${baseUrl}be-admin/persyaratan`;
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

function editSyarat(id) {
    $("#editSyarat").modal("show");
    $.ajax({
        url: `${urlApi}persyaratan/detail/${id}`,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        success: function (response) {
            let res = response?.data;
            $("#editSyarat #editTipe").on("change", function () {
                if ($("#editSyarat #editTipe").val() == "file") {
                    $("#row-Editformat").removeClass("d-none");
                } else {
                    $("#row-Editformat").addClass("d-none");
                }
            });

            if (res?.type == "file") {
                $("#row-Editformat").removeClass("d-none");
                $("#editSyarat #editPersyaratan").val(res?.syarat);
                $("select[name=editValueTipe]").val(res?.type);
                $("select[name=editValueFile]").val(res?.format);
                $(".selectpicker").selectpicker("refresh");
            } else {
                $("#row-Editformat").addClass("d-none");
                $("#editSyarat #editPersyaratan").val(res?.syarat);
                $("select[name=editValueTipe]").val(res?.type);
                $(".selectpicker").selectpicker("refresh");
            }
        },
        error: function (xhr) {
            handleErrorSimpan(xhr);
        },
    });

    $("#editSyarat #btn-ubah").on("click", function () {
        var formData = new FormData(document.getElementById("formPersyaratan"));
        if ($("#editSyarat #editTipe").val() == "file") {
            formData.append(
                "persyaratan",
                $("#editSyarat #editPersyaratan").val()
            );
            formData.append("type", $("#editSyarat #editTipe").val());
            formData.append("format", $("#editSyarat #editFormat").val());
        } else {
            formData.append(
                "persyaratan",
                $("#editSyarat #editPersyaratan").val()
            );
            formData.append("type", $("#editSyarat #editTipe").val());
            // formData.append("format", "");
        }

        loadStart();
        $.ajax({
            url: `${urlApi}persyaratan/edit/${id}`,
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
                        window.location = `${baseUrl}be-admin/persyaratan`;
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
    });
}

function deleteSyarat(id) {
    Swal.fire({
        title: "Hapus Persyaratan Rekrutmen?",
        text: "Apakah anda yakin ingin menghapus persyaratan ini!",
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
                url: `${urlApi}persyaratan/delete/${id}`,
                type: "DELETE",
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
                            window.location = `${baseUrl}be-admin/persyaratan`;
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

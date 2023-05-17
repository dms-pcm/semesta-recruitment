jQuery(document).ready(function () {
    showTable();
    $("#nav-user").removeClass("collapsed");
});

function loadStart() {
    $(".loader").css("display", "flex");
}

function loadStop() {
    $(".loader").css("display", "none");
}

function nl2br(mystr, is_xhtml) {
    var simplebreaktag =
        is_xhtml || typeof is_xhtml === "undefined" ? "<br />" : "<br>";
    return (mystr + "").replace(
        /([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,
        "$1" + simplebreaktag + "$2"
    );
}

function showTable() {
    $("#tbl-user").DataTable({
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
            url: `${urlApi}user`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
            async: true,
            dataSrc: function (json) {
                // data = json?.data;
                return json.data;
            },
            error: function (xhr, error, code) {
                $("#tbl-user_processing").addClass("d-none");
                let html = `
                    <tr class="odd"><td colspan="5" class="dataTables_empty" valign="top">Tidak ditemukan data yang cocok</td></tr>
                `;
                $("#tbl-user tbody").html(html);
                handleErrorTable(xhr);
            },
        },
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
            },
            {
                data: "full_name",
                name: "full_name",
            },
            {
                data: "address",
                render: function (data, type, row) {
                    if (data == null) {
                        return `<span class="badge bg-warning">Belum diisi</span>`;
                    } else {
                        let result =
                            data.length > 110
                                ? data.slice(0, 110) + "..."
                                : data;
                        return nl2br(`${result}`);
                    }
                },
            },
            {
                data: "email",
                name: "email",
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

function view(id) {
    $("#view").modal("show");
    $.ajax({
        url: `${urlApi}user/detail/${id}`,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        success: function (response) {
            let res = response?.data;
            $("#nama").text(`${res?.full_name}`);
            $("#email").text(`${res?.email}`);
            if (res?.phone == null) {
                $("#phone").html(
                    `<span class="badge bg-warning">Belum diisi</span>`
                );
            } else {
                $("#phone").text(`${res?.phone}`);
            }
            if (res?.twitter == null) {
                $("#tw").html(
                    `<span class="badge bg-warning">Belum diisi</span>`
                );
            } else {
                $("#tw").text(`${res?.twitter}`);
            }
            if (res?.facebook == null) {
                $("#fb").html(
                    `<span class="badge bg-warning">Belum diisi</span>`
                );
            } else {
                $("#fb").text(`${res?.facebook}`);
            }
            if (res?.instagram == null) {
                $("#ig").html(
                    `<span class="badge bg-warning">Belum diisi</span>`
                );
            } else {
                $("#ig").text(`${res?.instagram}`);
            }
            if (res?.address == null) {
                $("#alamat").html(
                    `<span class="badge bg-warning">Belum diisi</span>`
                );
            } else {
                $("#alamat").text(`${res?.address}`);
            }
        },
        error: function (xhr) {
            handleErrorSimpan(xhr);
        },
    });
}

function hapus(id) {
    Swal.fire({
        title: "Hapus Data User?",
        text: "Apakah anda yakin ingin menghapus data user ini!",
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
                url: `${urlApi}user/delete/${id}`,
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
                            window.location = `${baseUrl}be-admin/data-user`;
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

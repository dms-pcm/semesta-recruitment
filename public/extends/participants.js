let data_table = "";
let id_peserta = "";
jQuery(document).ready(function () {
    getTitle();
    dataExport();
    daftarHadir();
    $("#nav-peserta").removeClass("collapsed");
});

function loadStart() {
    $(".loader").css("display", "flex");
}

function loadStop() {
    $(".loader").css("display", "none");
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
                if (window.location.href != baseUrl + "be-admin/data-peserta") {
                    let id = window.location.href.split("?");
                    if (element?.id == id[1]) {
                        $("#inputFilter").append(
                            '<option value="' +
                                element?.id +
                                '" selected>' +
                                element?.title +
                                "</option>"
                        );
                        filter();
                    } else {
                        $("#inputFilter").append(
                            '<option value="' +
                                element?.id +
                                '">' +
                                element?.title +
                                "</option>"
                        );
                    }
                } else {
                    $("#inputFilter").append(
                        '<option value="' +
                            element?.id +
                            '">' +
                            element?.title +
                            "</option>"
                    );
                }
                $(".selectpicker").selectpicker("refresh");
            });
        },
        error: function (xhr) {
            handleErrorTable(xhr);
        },
    });
}

function filter() {
    if ($("#inputFilter").val() == "") {
        Swal.fire({
            title: "Oopss...",
            icon: "warning",
            text: "Silahkan pilih rekrutmen terlebih dahulu",
            allowOutsideClick: false,
        });
    } else {
        loadStart();
        $.ajax({
            url: `${urlApi}participants/filter`,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
            data: {
                id_recruitment: $("#inputFilter").val(),
            },
            async: true,
            cache: false,
            success: function (response) {
                setTimeout(function () {
                    loadStop();
                }, 1000);
                data_table = response;
                show();
            },
            error: function (xhr) {
                setTimeout(function () {
                    loadStop();
                    handleErrorTable(xhr);
                    $("#export").addClass("d-none");
                    $("#btn-hadir").addClass("d-none");
                    $("#selectRekrutmen").addClass("d-none");
                    $("#nothing").removeClass("d-none");
                    $("#tbl-peserta").addClass("d-none");
                    $("#tbl-peserta_wrapper").addClass("d-none");
                }, 1000);
            },
        });
    }
}

function show() {
    $("#export").removeClass("d-none");
    // $("#btn-hadir").removeClass("d-none");
    $("#selectRekrutmen").addClass("d-none");
    $("#nothing").addClass("d-none");
    $("#tbl-peserta").removeClass("d-none");
    $("#tbl-peserta_wrapper").removeClass("d-none");
    var mytable = $("#tbl-peserta").DataTable({
        responsive: true,
        destroy: true,
        language: {
            zeroRecords: "Tidak ditemukan data yang cocok",
            oPaginate: {
                sPrevious: "<span aria-hidden='true'>«</span>",
                sNext: "<span aria-hidden='true'>»</span>",
            },
        },
        data: [],
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
            },
            {
                data: "name_user",
                name: "name_user",
            },
            {
                data: "phone",
                name: "phone",
            },
            {
                data: "address",
                name: "address",
            },
            {
                data: "email",
                name: "email",
            },
            {
                data: "status_berkas",
                render: function (data, type, row) {
                    if (data == 1) {
                        $("#viewParticipant #btn-complete").prop(
                            "disabled",
                            false
                        );
                        $("#viewParticipant #btn-incomplete").prop(
                            "disabled",
                            false
                        );
                        return `<span class="badge bg-warning text-dark">Perlu Pemeriksaan</span>`;
                    } else if (data == 2) {
                        $("#viewParticipant #btn-complete").prop(
                            "disabled",
                            true
                        );
                        $("#viewParticipant #btn-incomplete").prop(
                            "disabled",
                            true
                        );
                        return `<span class="badge bg-success">Sudah Lengkap</span>`;
                    } else if (data == 3) {
                        $("#viewParticipant #btn-complete").prop(
                            "disabled",
                            true
                        );
                        $("#viewParticipant #btn-incomplete").prop(
                            "disabled",
                            true
                        );
                        return `<span class="badge bg-danger">Belum Lengkap</span>`;
                    }
                },
            },
            {
                data: "status_peserta",
                render: function (data, type, row) {
                    if (data == null) {
                        return `<i class="bi bi-dash-lg"></i>`;
                    } else if (data == 1) {
                        return `<span class="badge bg-danger">Tidak Lolos Seleksi</span>`;
                    } else if (data == 2) {
                        return `<span class="badge bg-success">Lolos Seleksi</span>`;
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

    var logs = data_table?.data;
    mytable.clear();
    $.each(logs, function (index, value) {
        mytable.row.add(value);
    });
    mytable.draw();
}

function view(id) {
    id_peserta = id;
    $("#viewParticipant").modal("show");
    $.ajax({
        url: `${urlApi}participants/detail/${id}`,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        async: true,
        cache: false,
        success: async function (response) {
            let res = response?.data;
            $("#viewNama").text(res?.name_user);
            $("#viewPhone").text(res?.phone);
            $("#viewAlamat").text(res?.address);
            $("#viewEmail").text(res?.email);
            if (res?.status_berkas == 1) {
                $("#viewParticipant #alasan").addClass("d-none");
                $("#viewParticipant #viewAlasan").text("");
                $("#viewParticipant #btn-complete").prop("disabled", false);
                $("#viewParticipant #btn-incomplete").prop("disabled", false);
                $("#viewStatusBerkas").html(
                    `<span class="badge bg-warning text-dark">Perlu Pemeriksaan</span>`
                );
            } else if (res?.status_berkas == 2) {
                $("#viewParticipant #alasan").addClass("d-none");
                $("#viewParticipant #viewAlasan").text("");
                $("#viewParticipant #btn-complete").prop("disabled", true);
                $("#viewParticipant #btn-incomplete").prop("disabled", true);
                $("#viewStatusBerkas").html(
                    `<span class="badge bg-success">Sudah Lengkap</span>`
                );
            } else if (res?.status_berkas == 3) {
                $("#viewParticipant #alasan").removeClass("d-none");
                $("#viewParticipant #viewAlasan").text(
                    res?.alasan_berkasTidakLengkap
                );
                $("#viewParticipant #btn-complete").prop("disabled", true);
                $("#viewParticipant #btn-incomplete").prop("disabled", true);
                $("#viewStatusBerkas").html(
                    `<span class="badge bg-danger">Belum Lengkap</span>`
                );
            }

            if (res?.status_peserta == null) {
                $("#viewStatusPeserta").html(`<i class="bi bi-dash-lg"></i>`);
            } else if (res?.status_peserta == 1) {
                $("#viewStatusPeserta").html(
                    `<span class="badge bg-danger">Tidak Lolos Seleksi</span>`
                );
            } else if (res?.status_peserta == 2) {
                $("#viewStatusPeserta").html(
                    `<span class="badge bg-success">Lolos Seleksi</span>`
                );
            }

            // if (res?.tb != null) {
            //     $("#tb").removeClass("d-none");
            //     $("#viewTB").text(res?.tb + " cm");
            // } else if (res?.tb == null) {
            //     $("#tb").addClass("d-none");
            // }

            // if (res?.bb != null) {
            //     $("#bb").removeClass("d-none");
            //     $("#viewBB").text(res?.bb + " kg");
            // } else if (res?.bb == null) {
            //     $("#bb").addClass("d-none");
            // }

            //berkas
            let data_peserta = res?.berkas;
            let html = ``;
            let berkas_diri = res?.berkas_diri;
            let htmlBerkas = ``;
            try {
                const response = await $.ajax({
                    url: `${urlApi}persyaratan/show`,
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                });
                await Promise.all(
                    $.each(data_peserta, function (index, element) {
                        for (let i = 0; i < response.data.length; i++) {
                            //list kualifikasi
                            if (element?.syarat_id == response.data[i]?.id) {
                                let file = element?.attachment.split(".");
                                // part = response.data[i]?.syarat;
                                if (file[1] == "jpg") {
                                    html += `
                                        <div class="col-md-4">
                                            <div class="card">
                                                <img src="${baseUrl}storage/${element?.attachment}" data-fancybox data-caption="${response.data[i]?.syarat}-${res?.name_user}" class="card-img-top" style="cursor:pointer;height:9rem;object-fit:cover;" alt="...">
                                                <div class="card-body" style="padding: 0px 10px 10px 10px;">
                                                    <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">${response.data[i]?.syarat}</h6>
                                                    <button type="button" onclick="unduh(${element?.id})" id="dw-${element?.id}" data-ekstension="${element?.attachment}" data-file="${response.data[i]?.syarat}" data-nama="${res?.name_user}" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        `;
                                } else if (file[1] == "jpeg") {
                                    html += `
                                    <div class="col-md-4">
                                        <div class="card">
                                            <img src="${baseUrl}storage/${element?.attachment}" data-fancybox data-caption="${response.data[i]?.syarat}-${res?.name_user}" class="card-img-top" style="cursor:pointer;height:9rem;object-fit:cover;" alt="...">
                                            <div class="card-body" style="padding: 0px 10px 10px 10px;">
                                                <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">${response.data[i]?.syarat}</h6>
                                                <button type="button" onclick="unduh(${element?.id})" id="dw-${element?.id}" data-ekstension="${element?.attachment}" data-file="${response.data[i]?.syarat}" data-nama="${res?.name_user}" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                                } else if (file[1] == "pdf") {
                                    html += `
                                    <div class="col-md-4">
                                        <div class="card">
                                            <img src="${baseUrl}be/assets/img/thumbnail-pdf.png" class="card-img-top" style="height:9rem;object-fit:cover;" alt="...">
                                            <div class="card-body" style="padding: 0px 10px 10px 10px;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">${
                                                            response.data[i]
                                                                ?.syarat
                                                        }</h6>
                                                    </div>
                                                    <div class="col-md-6" style="padding-top:20px;padding-bottom: 20px;">
                                                        <a href="${urlApi}participants/preview/${
                                        element?.id
                                    }?token=${localStorage.getItem(
                                        "token"
                                    )}" target="_blank">Preview</a><br>
                                                    </div>
                                                </div>
                                                <button type="button" onclick="unduh(${
                                                    element?.id
                                                })" id="dw-${
                                        element?.id
                                    }" data-ekstension="${
                                        element?.attachment
                                    }" data-file="${
                                        response.data[i]?.syarat
                                    }" data-nama="${
                                        res?.name_user
                                    }" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                                } else if (file[1] == "png") {
                                    html += `
                                    <div class="col-md-4">
                                        <div class="card">
                                            <img src="${baseUrl}storage/${element?.attachment}" data-fancybox data-caption="${response.data[i]?.syarat}-${res?.name_user}" class="card-img-top" style="cursor:pointer;height:9rem;object-fit:cover;" alt="...">
                                            <div class="card-body" style="padding: 0px 10px 10px 10px;">
                                                <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">${response.data[i]?.syarat}</h6>
                                                <button type="button" onclick="unduh(${element?.id})" id="dw-${element?.id}" data-ekstension="${element?.attachment}" data-file="${response.data[i]?.syarat}" data-nama="${res?.name_user}" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                                }
                            }
                        }
                        $("#berkas").html(html);
                        // data.push(part);
                    }),
                    $.each(berkas_diri, function (i, v) {
                        for (let i = 0; i < response.data.length; i++) {
                            if (v?.syarat_id == response.data[i]?.id) {
                                htmlBerkas += `
                                <div class="row" style="margin-bottom: 18px;">
                                    <div class="col-lg-3 col-md-4 label fw-bold">${response.data[i]?.syarat}</div>
                                    <div class="col-lg-9 col-md-8" id="">${v?.value}</div>
                                </div>
                                `;
                            }
                        }
                        $("#data-diri").html(htmlBerkas);
                    })
                );
            } catch (error) {
                handleErrorSimpan(error);
            }
            // $.each(data_peserta, function (index, element) {
            //     let file = element?.attachment.split(".");
            //     let title = "";
            //     if (element?.syarat_id == 1) {
            //         title = "Surat Lamaran";
            //     } else if (element?.syarat_id == 2) {
            //         title = "CV";
            //     } else if (element?.syarat_id == 3) {
            //         title = "Pas Foto";
            //     } else if (element?.syarat_id == 4) {
            //         title = "Foto Full Body";
            //     } else if (element?.syarat_id == 5) {
            //         title = "Ijazah";
            //     } else if (element?.syarat_id == 6) {
            //         title = "SKHUN";
            //     } else if (element?.syarat_id == 7) {
            //         title = "Nilai Raport";
            //     } else if (element?.syarat_id == 8) {
            //         title = "Surat Keterangan Sehat";
            //     } else if (element?.syarat_id == 9) {
            //         title = "Tidak Buta Warna";
            //     } else if (element?.syarat_id == 12) {
            //         title = "Essay Tentang Pengalaman Hidup";
            //     } else if (element?.syarat_id == 13) {
            //         title = "Essay Tentang Target Masa Depan";
            //     }

            //     if (file[1] == "jpg") {
            //         html += `
            //         <div class="col-md-4">
            //             <div class="card">
            //                 <img src="${baseUrl}storage/${element?.attachment}" data-fancybox data-caption="${title}-${res?.name_user}" class="card-img-top" style="cursor:pointer;height:9rem;object-fit:cover;" alt="...">
            //                 <div class="card-body" style="padding: 0px 10px 10px 10px;">
            //                     <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">${title}</h6>
            //                     <button type="button" onclick="unduh(${element?.id})" id="dw-${element?.id}" data-ekstension="${element?.attachment}" data-file="${title}" data-nama="${res?.name_user}" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></button>
            //                 </div>
            //             </div>
            //         </div>
            //         `;
            //     } else if (file[1] == "jpeg") {
            //         html += `
            //         <div class="col-md-4">
            //             <div class="card">
            //                 <img src="${baseUrl}storage/${element?.attachment}" data-fancybox data-caption="${title}-${res?.name_user}" class="card-img-top" style="cursor:pointer;height:9rem;object-fit:cover;" alt="...">
            //                 <div class="card-body" style="padding: 0px 10px 10px 10px;">
            //                     <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">${title}</h6>
            //                     <button type="button" onclick="unduh(${element?.id})" id="dw-${element?.id}" data-ekstension="${element?.attachment}" data-file="${title}" data-nama="${res?.name_user}" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></button>
            //                 </div>
            //             </div>
            //         </div>
            //         `;
            //     } else if (file[1] == "pdf") {
            //         html += `
            //         <div class="col-md-4">
            //             <div class="card">
            //                 <img src="${baseUrl}be/assets/img/thumbnail-pdf.png" class="card-img-top" style="height:9rem;object-fit:cover;" alt="...">
            //                 <div class="card-body" style="padding: 0px 10px 10px 10px;">
            //                     <div class="row">
            //                         <div class="col-md-6">
            //                             <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">${title}</h6>
            //                         </div>
            //                         <div class="col-md-6" style="padding-top:20px;padding-bottom: 20px;">
            //                             <a href="${urlApi}participants/preview/${
            //             element?.id
            //         }?token=${localStorage.getItem(
            //             "token"
            //         )}" target="_blank">Preview</a><br>
            //                         </div>
            //                     </div>
            //                     <button type="button" onclick="unduh(${
            //                         element?.id
            //                     })" id="dw-${element?.id}" data-ekstension="${
            //             element?.attachment
            //         }" data-file="${title}" data-nama="${
            //             res?.name_user
            //         }" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></button>
            //                 </div>
            //             </div>
            //         </div>
            //         `;
            //     } else if (file[1] == "png") {
            //         html += `
            //         <div class="col-md-4">
            //             <div class="card">
            //                 <img src="${baseUrl}storage/${element?.attachment}" data-fancybox data-caption="${title}-${res?.name_user}" class="card-img-top" style="cursor:pointer;height:9rem;object-fit:cover;" alt="...">
            //                 <div class="card-body" style="padding: 0px 10px 10px 10px;">
            //                     <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">${title}</h6>
            //                     <button type="button" onclick="unduh(${element?.id})" id="dw-${element?.id}" data-ekstension="${element?.attachment}" data-file="${title}" data-nama="${res?.name_user}" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></button>
            //                 </div>
            //             </div>
            //         </div>
            //         `;
            //     }
            // });
            // $("#berkas").html(html);
        },
        error: function (xhr) {
            handleErrorSimpan(xhr);
        },
    });
}

// function buka(id) {
//
//     $.ajax({
//         url: `${urlApi}participants/preview/${id}`,
//         type: "GET",
//         // xhrFields: {
//         //     responseType: "blob",
//         // },
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//             Authorization: "Bearer " + localStorage.getItem("token"),
//         },
//         success: function (response) {
//
//         },
//         error: function (xhr) {
//             // handle kesalahan
//             handleErrorSimpan(xhr);
//         },
//     });
// }

function unduh(id) {
    let extension = $("#dw-" + id + "")
        .attr("data-ekstension")
        .split(".");
    //
    let dataFileName = $("#dw-" + id + "").attr("data-file");
    let namaUser = $("#dw-" + id + "").attr("data-nama");
    $.ajax({
        url: `${urlApi}participants/download/${id}`,
        type: "GET",
        xhrFields: {
            responseType: "blob",
        },
        data: {
            namefile: dataFileName,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        success: function (response) {
            var a = document.createElement("a");
            var url = window.URL.createObjectURL(response);
            a.href = url;
            var fileName = `${dataFileName}-${namaUser}.${extension[1]}`;
            a.setAttribute("download", fileName);
            document.body.appendChild(a);
            a.click();
            setTimeout(function () {
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            }, 0);
        },
        error: function (xhr) {
            // handle kesalahan
            handleErrorSimpan(xhr);
        },
    });
}

function tutup() {
    $("#viewParticipant").modal("hide");
    $("#btn-viewBerkas").addClass("collapsed");
    $("#btn-viewBerkas").attr("aria-expanded", "false");
    $("#collapseTwo").removeClass("show");
}

function hapus(id) {
    Swal.fire({
        title: "Hapus Data Peserta?",
        text: "Apakah anda yakin ingin menghapus data ini!",
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
                url: `${urlApi}participants/delete/${id}`,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
                async: true,
                cache: false,
                success: function (response) {
                    setTimeout(function () {
                        loadStop();
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.status.message,
                            icon: "success",
                            allowOutsideClick: false,
                        }).then((result) => {
                            // window.location = `${baseUrl}be-admin/data-peserta`;
                            filter();
                            $("#viewParticipant").modal("hide");
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

function complete_file() {
    loadStart();
    $.ajax({
        url: `${urlApi}participants/complete/${id_peserta}`,
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        async: true,
        cache: false,
        success: function (response) {
            setTimeout(function () {
                loadStop();
                Swal.fire({
                    title: "Berhasil!",
                    text: response.status.message,
                    icon: "success",
                    allowOutsideClick: false,
                }).then((result) => {
                    // window.location = `${baseUrl}be-admin/data-peserta`;
                    filter();
                    $("#viewParticipant").modal("hide");
                });
            }, 1000);
        },
        error: function (xhr) {
            let code = xhr.status;
            setTimeout(function () {
                loadStop();
                if (code == "404") {
                    Swal.fire({
                        title: "Oppss...",
                        text: "Data peserta tidak ditemukan",
                        icon: "error",
                        allowOutsideClick: false,
                    });
                } else {
                    handleErrorTable(xhr);
                }
            }, 1000);
        },
    });
}

function incomplete_file() {
    Swal.fire({
        title: "Alasan berkas tidak lengkap",
        text: "Tulis alasan kenapa berkas tidak lengkap:",
        input: "text",
        inputPlaceholder: "Contoh : Surat lamaran tidak jelas",
        showCancelButton: true,
        allowOutsideClick: false,
        // inputAttributes: {
        //     required: "true",
        // },
        customClass: {
            validationMessage: "my-validation-message",
        },
        preConfirm: (value) => {
            if (!value) {
                Swal.showValidationMessage(
                    '<i class="fa fa-info-circle"></i> Alasan berkas tidak lengkap diperlukan'
                );
            }
        },
    }).then((result) => {
        if (result.value) {
            loadStart();
            $.ajax({
                url: `${urlApi}participants/incomplete/${id_peserta}`,
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
                data: {
                    alasan: result.value,
                },
                async: true,
                cache: false,
                success: function (response) {
                    setTimeout(function () {
                        loadStop();
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.status.message,
                            icon: "success",
                            allowOutsideClick: false,
                        }).then((result) => {
                            // window.location = `${baseUrl}be-admin/data-peserta`;
                            filter();
                            $("#viewParticipant").modal("hide");
                        });
                    }, 1000);
                },
                error: function (xhr) {
                    let code = xhr.status;
                    setTimeout(function () {
                        loadStop();
                        if (code == "404") {
                            Swal.fire({
                                title: "Oppss...",
                                text: "Data peserta tidak ditemukan",
                                icon: "error",
                                allowOutsideClick: false,
                            });
                        } else {
                            handleErrorTable(xhr);
                        }
                    }, 1000);
                },
            });
        }
    });
}

function accept(id) {
    Swal.fire({
        title: "Lolos Seleksi?",
        text: "Apakah anda yakin ingin menyatakan peserta ini lolos seleksi!",
        icon: "warning",
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonColor: "#20c997",
        cancelButtonColor: "#acacac",
        cancelButtonText: "Batal",
        confirmButtonText: "Iya, Yakin",
    }).then((result) => {
        if (result.isConfirmed) {
            loadStart();
            $.ajax({
                url: `${urlApi}participants/accept/${id}`,
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
                            filter();
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
function decline(id) {
    Swal.fire({
        title: "Tidak Lolos Seleksi?",
        text: "Apakah anda yakin ingin menyatakan peserta ini tidak lolos seleksi!",
        icon: "warning",
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#acacac",
        cancelButtonText: "Batal",
        confirmButtonText: "Iya, Yakin",
    }).then((result) => {
        if (result.isConfirmed) {
            loadStart();
            $.ajax({
                url: `${urlApi}participants/decline/${id}`,
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
                            filter();
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

function dataExport() {
    $("#data-peserta").on("click", function () {
        Swal.fire({
            title: "Export Data Peserta?",
            text: "Apakah anda yakin ingin mengexport data peserta rekrutmen ini!",
            icon: "warning",
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: "#198754",
            cancelButtonColor: "#acacac",
            cancelButtonText: "Batal",
            confirmButtonText: "Iya, Export",
        }).then((result) => {
            if (result.isConfirmed) {
                loadStart();
                var id = $("#inputFilter option:selected").val();
                var value = $("#inputFilter option:selected").text();
                $.ajax({
                    url: `${urlApi}export`,
                    type: "GET",
                    data: {
                        id_rekt: id,
                        nama_rekt: value,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                    xhrFields: {
                        responseType: "blob",
                    },
                    success: function (response, status, xhr) {
                        setTimeout(function () {
                            loadStop();
                            var filename = "";
                            var disposition = xhr.getResponseHeader(
                                "Content-Disposition"
                            );
                            if (
                                disposition &&
                                disposition.indexOf("attachment") !== -1
                            ) {
                                var filenameRegex =
                                    /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                                var matches = filenameRegex.exec(disposition);
                                if (matches != null && matches[1]) {
                                    filename = matches[1].replace(/['"]/g, "");
                                }
                            }
                            var link = document.createElement("a");
                            link.href = window.URL.createObjectURL(response);
                            link.download = filename;
                            link.click();
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
    });
}

function daftarHadir() {
    $("#daftar-hadir").on("click", function () {
        Swal.fire({
            title: "Export Daftar Hadir?",
            text: "Apakah anda yakin ingin mengexport daftar hadir rekrutmen ini!",
            icon: "warning",
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: "#198754",
            cancelButtonColor: "#acacac",
            cancelButtonText: "Batal",
            confirmButtonText: "Iya, Export",
        }).then((result) => {
            if (result.isConfirmed) {
                loadStart();
                var id = $("#inputFilter option:selected").val();
                var value = $("#inputFilter option:selected").text();
                $.ajax({
                    url: `${urlApi}export/data-hadir`,
                    type: "GET",
                    data: {
                        rekt_id: id,
                        nama_rekt: value,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                    xhrFields: {
                        responseType: "blob",
                    },
                    success: function (response, status, xhr) {
                        setTimeout(function () {
                            loadStop();
                            var filename = "";
                            var disposition = xhr.getResponseHeader(
                                "Content-Disposition"
                            );
                            if (
                                disposition &&
                                disposition.indexOf("attachment") !== -1
                            ) {
                                var filenameRegex =
                                    /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                                var matches = filenameRegex.exec(disposition);
                                if (matches != null && matches[1]) {
                                    filename = matches[1].replace(/['"]/g, "");
                                }
                            }
                            var link = document.createElement("a");
                            link.href = window.URL.createObjectURL(response);
                            link.download = filename;
                            link.click();
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
    });
}

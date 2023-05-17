let dataRekt;
jQuery(document).ready(function () {
    showDetail();
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

// function preview() {
//     pas_foto.onchange = (evt) => {
//         const [file] = pas_foto.files;
//         if (file) {
//             blah_pas.src = URL.createObjectURL(file);
//         }
//     };

//     full_body.onchange = (evt) => {
//         const [file] = full_body.files;
//         if (file) {
//             blah_full.src = URL.createObjectURL(file);
//         }
//     };
// }

function profile() {
    $.ajax({
        url: `${urlApi}profile`,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        success: async function (response) {
            let res = response?.data[0];
            if (res?.full_name != null) {
                $("#apply #nama").val(res?.full_name);
            }
            if (res?.phone != null) {
                $("#apply #noHp").val(res?.phone);
            }
            if (res?.address != null) {
                $("#apply #alamat").val(res?.address);
            }
            if (res?.email != null) {
                $("#apply #email").val(res?.email);
            }

            // let syarat = dataRekt?.persyaratan;
            // syarat.forEach(async function (part, index) {
            //     if (res?.cv != null && part?.persyaratan_id == 2) {
            //         const fileInput = document.querySelector(
            //             '#apply #row-2 input[type="file"]'
            //         );
            //         const myFile = new File(
            //             [
            //                 await fetch(
            //                     `${urlApi}profile/getCV/${
            //                         res?.id
            //                     }?token=${localStorage.getItem("token")}`
            //                 ).then((r) => r.blob()),
            //             ],
            //             res?.originalName,
            //             {
            //                 type: "application/pdf",
            //                 lastModified: new Date(),
            //             }
            //         );
            //         const dataTransfer = new DataTransfer();
            //         dataTransfer.items.add(myFile);
            //         fileInput.files = dataTransfer.files;
            //     }
            // }, syarat);

            let syarat = dataRekt?.persyaratan;
            await Promise.all(
                syarat.map(async (part) => {
                    if (res?.cv != null && part?.persyaratan_id == 2) {
                        const fileInput = document.querySelector(
                            '#apply #row-2 input[type="file"]'
                        );
                        if (fileInput !== null) {
                            const myFile = new File(
                                [
                                    await fetch(
                                        `${urlApi}profile/getCV/${
                                            res?.id
                                        }?token=${localStorage.getItem(
                                            "token"
                                        )}`
                                    ).then((r) => r.blob()),
                                ],
                                res?.originalName,
                                {
                                    type: "application/pdf",
                                    lastModified: new Date(),
                                }
                            );
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(myFile);
                            fileInput.files = dataTransfer.files;
                        }
                    }
                })
            );
        },
        error: function (xhr) {
            handleErrorSimpan(xhr);
        },
    });
}

function participant() {
    var url = document.URL;
    var idRekt = url.substring(url.lastIndexOf("=") + 1);
    $.ajax({
        url: `${urlApi}participants`,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        success: function (response) {
            for (let i = 0; i < response?.data.length; i++) {
                if (
                    localStorage.getItem("user") ==
                        response?.data[i]?.user_id &&
                    response?.data[i]?.recruitment_id == idRekt
                ) {
                    $("#btn-modal").prop("disabled", true);
                    $("#attention").removeClass("d-none");
                    break;
                } else {
                    $("#btn-modal").prop("disabled", false);
                    $("#attention").addClass("d-none");
                }

                if ($("#quantity").text() == "Sudah Habis") {
                    $("#btn-modal").prop("disabled", true);
                }
                // else {
                //     $("#btn-modal").prop("disabled", false);
                //     $("#attention").addClass("d-none");
                // }
            }

            // $.each(response?.data, function (i, v) {
            //     if (
            //         localStorage.getItem("user") == v?.user_id &&
            //         v?.recruitment_id == idRekt
            //     ) {
            //         $("#btn-modal").prop("disabled", true);
            //         $("#attention").removeClass("d-none");
            //         break;
            //     } else if ($("#quantity").text() != "Sudah Habis") {
            //         $("#btn-modal").prop("disabled", false);
            //         $("#attention").addClass("d-none");
            //     } else {
            //         $("#btn-modal").prop("disabled", true);
            //     }
            // });
        },
        error: function (xhr) {},
    });
}

function showDetail() {
    var url = document.URL;
    var id = url.substring(url.lastIndexOf("=") + 1);
    $.ajax({
        url: `${urlApi}detail-rekt/${id}`,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        success: async function (response) {
            if (localStorage.getItem("token") != null) {
                participant();
                // profile();
            }
            let res = response?.data;
            dataRekt = res;
            let waktu = res?.clock.split(" ");
            $("#lokasi").html(nl2br(`${res?.location}`));
            $("#tgl").text(`${waktu[0]} ${waktu[1]} ${waktu[2]}`);
            $("#pukul").text(`${waktu[3]} WIB`);
            if (res?.current_quantity == null) {
                $("#quantity").text(`Tersisa ${res?.quantity} peserta`);
            } else if (res?.current_quantity == 0) {
                $("#quantity").text(`Sudah Habis`);
            } else {
                $("#quantity").text(`Tersisa ${res?.current_quantity} peserta`);
            }
            $("#img-rekt").html(`
            <a href="${baseUrl}storage/${res?.attachment}" title="Flayer ${res?.title}" data-fancybox
					data-caption="Flayer ${res?.title}"><img src="${baseUrl}storage/${res?.attachment}" style="width:100%;height:541px;object-fit:cover;" class="img-fluid services-img" alt="Flayer ${res?.title}"></img></a>
            `);
            $("#judul").text(res?.title);
            $("#desk").html(nl2br(res?.description));
            let syarat = res?.persyaratan;
            let data = [];
            let html = ``;
            try {
                const response = await $.ajax({
                    url: `${urlApi}persyaratan/show`,
                    type: "GET",
                    // headers: {
                    //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    //         "content"
                    //     ),
                    //     Authorization:
                    //         "Bearer " + localStorage.getItem("token"),
                    // },
                });
                await Promise.all(
                    syarat.map(async (part, index) => {
                        for (let i = 0; i < response.data.length; i++) {
                            //list kualifikasi
                            if (part?.persyaratan_id == response.data[i]?.id) {
                                part = response.data[i]?.syarat;
                                if (
                                    response.data[i]?.type == "file" &&
                                    response.data[i]?.format == "pdf"
                                ) {
                                    html = `
                                        <div class="mb-3 hadir" id="row-${response.data[i]?.id}">
                                            <label for="berkas-${response.data[i]?.id}" class="form-label">${response.data[i]?.syarat}</label>
                                            <input type="file" class="form-control input-berkas" name="${response.data[i]?.id}" data-title="${response.data[i]?.syarat}" id="berkas-${response.data[i]?.id}" accept=".pdf">
                                        </div>
                                        `;
                                } else if (
                                    response.data[i]?.type == "file" &&
                                    response.data[i]?.format == "png,jpeg,jpg"
                                ) {
                                    html = `
                                        <div class="row mb-3 hadir" id="row-${response.data[i]?.id}">
                                            <div class="col-md-6">
                                                <label for="" class="form-label">${response.data[i]?.syarat}</label>
                                                <div class="input-group">
                                                    <label class="btn btn-primary" style="border-radius: 5px;" for="berkas-${response.data[i]?.id}"><i class="bi bi-pencil-fill me-1"></i> Pilih File</label>
                                                    <input type="file" class="form-control d-none input-berkas gambar" name="${response.data[i]?.id}" data-title="${response.data[i]?.syarat}" id="berkas-${response.data[i]?.id}" accept="image/png, image/jpg, image/jpeg">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="" class="form-label">Preview</label>
                                                <img class="img-upload-rekrutmen" id="pict-${response.data[i]?.id}" src="${baseUrl}fe/assets/img/user.png" alt="">
                                            </div>
                                        </div>
                                        `;
                                } else if (
                                    response.data[i]?.type == "text" &&
                                    response.data[i]?.format == null
                                ) {
                                    html = `
                                        <div class="mb-3 hadir" id="row-${response.data[i]?.id}">
                                            <label for="berkas-${response.data[i]?.id}" class="form-label">${response.data[i]?.syarat}</label>
                                            <input type="text" class="form-control input-berkas input-berkas-teks" name="${response.data[i]?.id}" data-title="${response.data[i]?.syarat}" id="berkas-${response.data[i]?.id}" placeholder="Masukan ${response.data[i]?.syarat}">
                                        </div>
                                        `;
                                }
                                break;
                            }
                        }
                        $("#formberkas").append(html);
                        data.push(part);
                        $("#formberkas").on(
                            "change",
                            ".gambar",
                            function (event) {
                                const file = event.target.files[0];
                                const id = event.target.getAttribute("name");
                                if (file) {
                                    $("#pict-" + id).attr(
                                        "src",
                                        URL.createObjectURL(file)
                                    );
                                }
                            }
                        );
                    })
                );
                if (localStorage.getItem("token") != null) {
                    profile();
                }
            } catch (error) {
                handleErrorSimpan(error);
            }

            // syarat.forEach(async function (part, index) {
            //     if (part?.persyaratan_id == 1) {
            //         part = "Surat Lamaran";
            //         $("#apply #row-lamaran").addClass("hadir");
            //         $("#apply #row-lamaran").removeClass("d-none");
            //     } else if (part?.persyaratan_id == 2) {
            //         part = "CV";
            //         $("#apply #row-cv").addClass("hadir");
            //         $("#apply #row-cv").removeClass("d-none");
            //     } else if (part?.persyaratan_id == 3) {
            //         part = "Pas Foto";
            //         $("#apply #row-foto").addClass("hadir");
            //         $("#apply #row-foto").removeClass("d-none");
            //     } else if (part?.persyaratan_id == 4) {
            //         part = "Foto Full Body";
            //         $("#apply #row-full").addClass("hadir");
            //         $("#apply #row-full").removeClass("d-none");
            //     } else if (part?.persyaratan_id == 5) {
            //         part = "Ijazah";
            //         $("#apply #row-ijazah").addClass("hadir");
            //         $("#apply #row-ijazah").removeClass("d-none");
            //     } else if (part?.persyaratan_id == 6) {
            //         part = "SKHUN";
            //         $("#apply #row-skhun").addClass("hadir");
            //         $("#apply #row-skhun").removeClass("d-none");
            //     } else if (part?.persyaratan_id == 7) {
            //         part = "Nilai Raport";
            //         $("#apply #row-raport").addClass("hadir");
            //         $("#apply #row-raport").removeClass("d-none");
            //     } else if (part?.persyaratan_id == 8) {
            //         part = "Surat Keterangan Sehat";
            //         $("#apply #row-sehat").addClass("hadir");
            //         $("#apply #row-sehat").removeClass("d-none");
            //     } else if (part?.persyaratan_id == 9) {
            //         part = "Tidak Buta Warna";
            //         $("#apply #row-warna").addClass("hadir");
            //         $("#apply #row-warna").removeClass("d-none");
            //     } else if (part?.persyaratan_id == 10) {
            //         part = "Tinggi Badan";
            //         $("#apply #row-tb").addClass("hadir");
            //         $("#apply #row-tb").removeClass("d-none");
            //     } else if (part?.persyaratan_id == 11) {
            //         part = "Berat Badan";
            //         $("#apply #row-bb").addClass("hadir");
            //         $("#apply #row-bb").removeClass("d-none");
            //     } else if (part?.persyaratan_id == 12) {
            //         part = "Essay Tentang Pengalaman Hidup";
            //         $("#apply #row-hidup").addClass("hadir");
            //         $("#apply #row-hidup").removeClass("d-none");
            //     } else if (part?.persyaratan_id == 13) {
            //         part = "Essay Tentang Target Masa Depan";
            //         $("#apply #row-depan").addClass("hadir");
            //         $("#apply #row-depan").removeClass("d-none");
            //     }
            //     data.push(part);
            // }, syarat);
            //
            let htmlSyarat = "";
            for (let i = 0; i < data.length; i++) {
                htmlSyarat += `
                <li><i class="bi bi-check-circle"></i> <span>${data[i]}</span></li>
                `;
            }
            $("#list-syarat").html(htmlSyarat);
        },
        error: function (xhr) {
            handleErrorSimpan(xhr);
        },
    });
}

function nl2br(mystr, is_xhtml) {
    var simplebreaktag =
        is_xhtml || typeof is_xhtml === "undefined" ? "<br />" : "<br>";
    return (mystr + "").replace(
        /([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,
        "$1" + simplebreaktag + "$2"
    );
}

function showModal() {
    if (localStorage.getItem("token") != null) {
        $("#apply").modal("show");
    } else {
        Swal.fire({
            icon: "warning",
            title: "Oops...",
            text: "Anda harus login terlebih dahulu, untuk melakukan pendaftaran!",
            allowOutsideClick: false,
        }).then((result) => {
            window.location = `${baseUrl}login`;
        });
    }
}

function daftar() {
    emptyData = [];
    if ($("#nama").val() == "") {
        emptyData.push({
            message: "Nama lengkap wajib di isi",
        });
    }
    if ($("#noHp").val() == "") {
        emptyData.push({
            message: "No.Handphone wajib di isi",
        });
    }
    if ($("#alamat").val() == "") {
        emptyData.push({
            message: "Alamat wajib di isi",
        });
    }
    if ($("#email").val() == "") {
        emptyData.push({
            message: "Email wajib di isi",
        });
    }
    if ($("#syarat").find("div.hadir")) {
        for (let i = 0; i < $("#syarat").find("div.hadir").length; i++) {
            //
            let idInput = $("#syarat").find(`div.hadir:eq(${i})`).attr("id");
            let idNya = idInput.split("-");
            let title = $("#syarat")
                .find(`div.hadir:eq(${i}) #berkas-${idNya[1]}`)
                .attr("data-title");
            if (
                $("#syarat").find(`div.hadir:eq(${i}) #berkas-${idNya[1]}`)
                    .length == 1 &&
                $("#syarat")
                    .find(`div.hadir:eq(${i}) #berkas-${idNya[1]}`)
                    .val() == ""
            ) {
                emptyData.push({
                    message: "Berkas " + title + " wajib di isi",
                });
            }
            // if (
            //     $("#syarat").find(`div.hadir:eq(${i}) #pas_foto`).length == 1 &&
            //     $("#syarat").find("div.hadir #pas_foto").val() == ""
            // ) {
            //     emptyData.push({
            //         message:
            //             "Berkas pas foto wajib di isi, dan format yang di perbolehkan .png, .jpg, .jpeg",
            //     });
            // } else if (
            //     $("#syarat").find(`div.hadir:eq(${i}) #full_body`).length ==
            //         1 &&
            //     $("#syarat").find("div.hadir #full_body").val() == ""
            // ) {
            //     emptyData.push({
            //         message:
            //             "Berkas foto full body wajib di isi, dan format yang di perbolehkan .png, .jpg, .jpeg",
            //     });
            // } else if (
            //     $("#syarat").find(`div.hadir:eq(${i}) #surat_lamaran`).length ==
            //         1 &&
            //     $("#syarat").find("div.hadir #surat_lamaran").val() == ""
            // ) {
            //     emptyData.push({
            //         message:
            //             "Berkas surat lamaran wajib di isi, dan format yang di perbolehkan .pdf",
            //     });
            // } else if (
            //     $("#syarat").find(`div.hadir:eq(${i}) #cv`).length == 1 &&
            //     $("#syarat").find("div.hadir #cv").val() == ""
            // ) {
            //     emptyData.push({
            //         message:
            //             "Berkas CV wajib di isi, dan format yang di perbolehkan .pdf",
            //     });
            // } else if (
            //     $("#syarat").find(`div.hadir:eq(${i}) #ijazah`).length == 1 &&
            //     $("#syarat").find("div.hadir #ijazah").val() == ""
            // ) {
            //     emptyData.push({
            //         message:
            //             "Berkas ijazah wajib di isi, dan format yang di perbolehkan .pdf",
            //     });
            // } else if (
            //     $("#syarat").find(`div.hadir:eq(${i}) #skhun`).length == 1 &&
            //     $("#syarat").find("div.hadir #skhun").val() == ""
            // ) {
            //     emptyData.push({
            //         message:
            //             "Berkas SKHUN wajib di isi, dan format yang di perbolehkan .pdf",
            //     });
            // } else if (
            //     $("#syarat").find(`div.hadir:eq(${i}) #raport`).length == 1 &&
            //     $("#syarat").find("div.hadir #raport").val() == ""
            // ) {
            //     emptyData.push({
            //         message:
            //             "Berkas nilai raport wajib di isi, dan format yang di perbolehkan .pdf",
            //     });
            // } else if (
            //     $("#syarat").find(`div.hadir:eq(${i}) #sk_sehat`).length == 1 &&
            //     $("#syarat").find("div.hadir #sk_sehat").val() == ""
            // ) {
            //     emptyData.push({
            //         message:
            //             "Berkas surat keterangan sehat wajib di isi, dan format yang di perbolehkan .pdf",
            //     });
            // } else if (
            //     $("#syarat").find(`div.hadir:eq(${i}) #buta_warna`).length ==
            //         1 &&
            //     $("#syarat").find("div.hadir #buta_warna").val() == ""
            // ) {
            //     emptyData.push({
            //         message:
            //             "Berkas tidak buta warna wajib di isi, dan format yang di perbolehkan .pdf",
            //     });
            // } else if (
            //     $("#syarat").find(`div.hadir:eq(${i}) #essay_hidup`).length ==
            //         1 &&
            //     $("#syarat").find("div.hadir #essay_hidup").val() == ""
            // ) {
            //     emptyData.push({
            //         message:
            //             "Berkas essay tentang pengalaman hidup wajib di isi, dan format yang di perbolehkan .pdf",
            //     });
            // } else if (
            //     $("#syarat").find(`div.hadir:eq(${i}) #essay_depan`).length ==
            //         1 &&
            //     $("#syarat").find("div.hadir #essay_depan").val() == ""
            // ) {
            //     emptyData.push({
            //         message:
            //             "Berkas essay tentang target masa depan wajib di isi, dan format yang di perbolehkan .pdf",
            //     });
            // } else if (
            //     $("#syarat").find(`div.hadir:eq(${i}) #tb`).length == 1 &&
            //     $("#syarat").find("div.hadir #tb").val() == ""
            // ) {
            //     emptyData.push({
            //         message: "Tinggi badan wajib di isi",
            //     });
            // } else if (
            //     $("#syarat").find(`div.hadir:eq(${i}) #bb`).length == 1 &&
            //     $("#syarat").find("div.hadir #bb").val() == ""
            // ) {
            //     emptyData.push({
            //         message: "Berat badan wajib di isi",
            //     });
            // }
        }
    }

    for (let i = 0; i < emptyData.length; i++) {
        var data = emptyData;

        var myTrackingContent = data
            .map(function (item) {
                return `<br>` + item.message;
            })
            .join("");
        Swal.fire({
            icon: "error",
            title: "Form tidak valid...",
            html:
                '<div class="swal2-html-container" id="swal2-html-container" style="display: block;overflow-y: scroll;max-height: 11em;">' +
                myTrackingContent +
                "</div>",
            allowOutsideClick: false,
        });
    }

    if (emptyData.length == 0) {
        let dataFile = [];
        let dataDiri = [];
        for (let i = 0; i < $(".input-berkas").length; i++) {
            if (
                $(`input[type='file']:eq(${i})`).val() &&
                $(`input[type='file']:eq(${i})`)[0].files[0].size != 0
            ) {
                dataFile.push({
                    syarat_id: $(`input[type='file']:eq(${i})`).attr("name"),
                    attachment: $(`input[type='file']:eq(${i})`).val()
                        ? $(`input[type='file']:eq(${i})`)[0].files[0]
                        : "",
                });
            }
        }

        for (let i = 0; i < $(".input-berkas-teks").length; i++) {
            if ($(".input-berkas-teks:eq(" + i + ")").val()) {
                dataDiri.push({
                    syarat_id: $(".input-berkas-teks:eq(" + i + ")").attr(
                        "name"
                    ),
                    value: $(".input-berkas-teks:eq(" + i + ")").val(),
                });
            }
        }

        // return false;
        var form_Data = new FormData();
        $.each(dataFile, function (i, v) {
            form_Data.append(
                `dataFile[${i}][attachment]`,
                dataFile[i]?.attachment
            );
            form_Data.append(
                `dataFile[${i}][syarat_id]`,
                dataFile[i]?.syarat_id
            );
        });

        $.each(dataDiri, function (i, v) {
            form_Data.append(`dataDiri[${i}][value]`, dataDiri[i]?.value);
            form_Data.append(
                `dataDiri[${i}][syarat_id]`,
                dataDiri[i]?.syarat_id
            );
        });

        form_Data.append("recruitment_id", dataRekt?.id);
        form_Data.append("recruitment_name", dataRekt?.title);
        form_Data.append("user_id", localStorage.getItem("user"));
        form_Data.append("name_user", $("#nama").val());
        form_Data.append("phone", $("#noHp").val());
        form_Data.append("address", $("#alamat").val());
        form_Data.append("email", $("#email").val());
        // form_Data.append("tb", $("#tb").val());
        // form_Data.append("bb", $("#bb").val());
        loadStart();
        $.ajax({
            url: `${urlApi}participants/create`,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
            data: form_Data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                setTimeout(function () {
                    loadStop();
                    Swal.fire({
                        title: "Berhasil!",
                        text: response.status.message,
                        icon: "success",
                        allowOutsideClick: false,
                    }).then((result) => {
                        window.location = `${baseUrl}detail-information?=${dataRekt?.id}`;
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
        return false;
    }
}

function tutup() {
    $("#apply").modal("hide");
    $("#btn-according-syarat").addClass("collapsed");
    $("#btn-according-syarat").attr("aria-expanded", "false");
    $("#syarat").removeClass("show");
    // $("#apply #formberkas").empty();
    // $("#blah_pas").attr("src", `${baseUrl}fe/assets/img/user.png`);
    // $("#blah_full").attr("src", `${baseUrl}fe/assets/img/user.png`);
    // $("#pas_foto").val("");
    // $("#full_body").val("");
    // $("#essay_depan").val("");
    // $("#essay_hidup").val("");
    // $("#buta_warna").val("");
    // $("#sk_sehat").val("");
    // $("#raport").val("");
    // $("#skhun").val("");
    // $("#ijazah").val("");
    // $("#cv").val("");
    // $("#surat_lamaran").val("");
    // $("#bb").val("");
    // $("#tb").val("");
}

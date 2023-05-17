let data = "";
let dataRektId = "";
let dataRektName = "";
jQuery(document).ready(function () {
    show();
    // preview();
});

function preview() {
    pas_foto.onchange = (evt) => {
        const [file] = pas_foto.files;
        if (file) {
            blah_pas.src = URL.createObjectURL(file);
        }
    };

    full_body.onchange = (evt) => {
        const [file] = full_body.files;
        if (file) {
            blah_full.src = URL.createObjectURL(file);
        }
    };
}

function show() {
    $("#history").DataTable({
        responsive: true,
        language: {
            zeroRecords: "Tidak ditemukan data yang cocok",
            oPaginate: {
                sPrevious: "<span aria-hidden='true'>«</span>",
                sNext: "<span aria-hidden='true'>»</span>",
            },
        },
        ajax: {
            url: `${urlApi}history`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
            async: true,
            dataSrc: function (json) {
                $("#nothing").addClass("d-none");
                $("#history").removeClass("d-none");
                $("#history_wrapper").removeClass("d-none");
                data = json?.data;
                // inputShow(json?.data);
                return json.data;
            },
            error: function (xhr, error, code) {
                $("#nothing").removeClass("d-none");
                $("#history").addClass("d-none");
                $("#history_wrapper").addClass("d-none");
                handleErrorTable(xhr);
            },
        },
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
            },
            {
                data: "recruitment_name",
                name: "recruitment_name",
            },
            {
                data: "rekrut.0.description",
                render: function (data, type, row) {
                    let result =
                        data.length > 100 ? data.slice(0, 100) + "..." : data;
                    return nl2br(`${result}`);
                },
            },
            {
                data: "status_berkas",
                render: function (data, type, row) {
                    if (data == 1) {
                        return `<span class="badge bg-warning text-dark">Proses Pemeriksaan</span>`;
                    } else if (data == 2) {
                        return `<span class="badge bg-success">Sudah Lengkap</span>`;
                    } else if (data == 3) {
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
}

// function inputShow(dataVal) {
//     $.each(dataVal, function (i, v) {
//         $.each(v?.berkas, function (s, t) {
//             let data = t?.originalName;
//             $.each(v?.rekrut, function (x, y) {
//                 dataRekt = y;
//
//                 let syarat = y?.persyaratan.split(",");
//                 // syarat.forEach(function (part, index) {
//                 //     if (this[index] == 1) {
//                 //         if (this[index] == t?.syarat_id) {
//                 //             const fileInput = document.querySelector(
//                 //                 '#edit #row-lamaran input[type="file"]'
//                 //             );
//                 //             const myFile = new File([""], data, {
//                 //                 type: "application/pdf",
//                 //                 lastModified: new Date(),
//                 //             });
//                 //             const dataTransfer = new DataTransfer();
//                 //             dataTransfer.items.add(myFile);
//                 //             fileInput.files = dataTransfer.files;
//                 //             $('#edit #row-lamaran input[type="file"]').attr(
//                 //                 "data-id",
//                 //                 t?.id
//                 //             );
//                 //         }
//                 //         $("#edit #row-lamaran").addClass("hadir");
//                 //         $("#edit #row-lamaran").removeClass("d-none");
//                 //     } else if (this[index] == 2) {
//                 //         if (this[index] == t?.syarat_id) {
//                 //             const fileInput = document.querySelector(
//                 //                 '#edit #row-cv input[type="file"]'
//                 //             );
//                 //             const myFile = new File([""], data, {
//                 //                 type: "application/pdf",
//                 //                 lastModified: new Date(),
//                 //             });
//                 //             const dataTransfer = new DataTransfer();
//                 //             dataTransfer.items.add(myFile);
//                 //             fileInput.files = dataTransfer.files;
//                 //             $('#edit #row-cv input[type="file"]').attr(
//                 //                 "data-id",
//                 //                 t?.id
//                 //             );
//                 //         }
//                 //         $("#edit #row-cv").addClass("hadir");
//                 //         $("#edit #row-cv").removeClass("d-none");
//                 //     } else if (this[index] == 3) {
//                 //         if (this[index] == t?.syarat_id) {
//                 //             const fileInput = document.querySelector(
//                 //                 '#edit #row-foto input[type="file"]'
//                 //             );
//                 //             const myFile = new File([""], data, {
//                 //                 type: "image/*",
//                 //                 lastModified: new Date(),
//                 //             });
//                 //             const dataTransfer = new DataTransfer();
//                 //             dataTransfer.items.add(myFile);
//                 //             fileInput.files = dataTransfer.files;
//                 //             $('#edit #row-foto input[type="file"]').attr(
//                 //                 "data-id",
//                 //                 t?.id
//                 //             );
//                 //         }
//                 //         $("#edit #row-foto").addClass("hadir");
//                 //         $("#edit #row-foto").removeClass("d-none");
//                 //     } else if (this[index] == 4) {
//                 //         if (this[index] == t?.syarat_id) {
//                 //             const fileInput = document.querySelector(
//                 //                 '#edit #row-full input[type="file"]'
//                 //             );
//                 //             const myFile = new File([""], data, {
//                 //                 type: "image/*",
//                 //                 lastModified: new Date(),
//                 //             });
//                 //             const dataTransfer = new DataTransfer();
//                 //             dataTransfer.items.add(myFile);
//                 //             fileInput.files = dataTransfer.files;
//                 //             $('#edit #row-full input[type="file"]').attr(
//                 //                 "data-id",
//                 //                 t?.id
//                 //             );
//                 //         }
//                 //         $("#edit #row-full").addClass("hadir");
//                 //         $("#edit #row-full").removeClass("d-none");
//                 //     } else if (this[index] == 5) {
//                 //         if (this[index] == t?.syarat_id) {
//                 //             const fileInput = document.querySelector(
//                 //                 '#edit #row-ijazah input[type="file"]'
//                 //             );
//                 //             const myFile = new File([""], data, {
//                 //                 type: "application/pdf",
//                 //                 lastModified: new Date(),
//                 //             });
//                 //             const dataTransfer = new DataTransfer();
//                 //             dataTransfer.items.add(myFile);
//                 //             fileInput.files = dataTransfer.files;
//                 //             $('#edit #row-ijazah input[type="file"]').attr(
//                 //                 "data-id",
//                 //                 t?.id
//                 //             );
//                 //         }
//                 //         $("#edit #row-ijazah").addClass("hadir");
//                 //         $("#edit #row-ijazah").removeClass("d-none");
//                 //     } else if (this[index] == 6) {
//                 //         if (this[index] == t?.syarat_id) {
//                 //             const fileInput = document.querySelector(
//                 //                 '#edit #row-skhun input[type="file"]'
//                 //             );

//                 //             const myFile = new File([""], data, {
//                 //                 type: "application/pdf",
//                 //                 lastModified: new Date(),
//                 //             });
//                 //             const dataTransfer = new DataTransfer();
//                 //             dataTransfer.items.add(myFile);
//                 //             fileInput.files = dataTransfer.files;
//                 //             //
//                 //             $('#edit #row-skhun input[type="file"]').attr(
//                 //                 "data-id",
//                 //                 t?.id
//                 //             );
//                 //         }
//                 //         $("#edit #row-skhun").addClass("hadir");
//                 //         $("#edit #row-skhun").removeClass("d-none");
//                 //     } else if (this[index] == 7) {
//                 //         if (this[index] == t?.syarat_id) {
//                 //             const fileInput = document.querySelector(
//                 //                 '#edit #row-raport input[type="file"]'
//                 //             );
//                 //             const myFile = new File([""], data, {
//                 //                 type: "application/pdf",
//                 //                 lastModified: new Date(),
//                 //             });
//                 //             const dataTransfer = new DataTransfer();
//                 //             dataTransfer.items.add(myFile);
//                 //             fileInput.files = dataTransfer.files;
//                 //             $('#edit #row-raport input[type="file"]').attr(
//                 //                 "data-id",
//                 //                 t?.id
//                 //             );
//                 //         }
//                 //         $("#edit #row-raport").addClass("hadir");
//                 //         $("#edit #row-raport").removeClass("d-none");
//                 //     } else if (this[index] == 8) {
//                 //         if (this[index] == t?.syarat_id) {
//                 //             const fileInput = document.querySelector(
//                 //                 '#edit #row-sehat input[type="file"]'
//                 //             );
//                 //             const myFile = new File([""], data, {
//                 //                 type: "application/pdf",
//                 //                 lastModified: new Date(),
//                 //             });
//                 //             const dataTransfer = new DataTransfer();
//                 //             dataTransfer.items.add(myFile);
//                 //             fileInput.files = dataTransfer.files;
//                 //             $('#edit #row-sehat input[type="file"]').attr(
//                 //                 "data-id",
//                 //                 t?.id
//                 //             );
//                 //         }
//                 //         $("#edit #row-sehat").addClass("hadir");
//                 //         $("#edit #row-sehat").removeClass("d-none");
//                 //     } else if (this[index] == 9) {
//                 //         if (this[index] == t?.syarat_id) {
//                 //             const fileInput = document.querySelector(
//                 //                 '#edit #row-warna input[type="file"]'
//                 //             );
//                 //             const myFile = new File([""], data, {
//                 //                 type: "application/pdf",
//                 //                 lastModified: new Date(),
//                 //             });
//                 //             const dataTransfer = new DataTransfer();
//                 //             dataTransfer.items.add(myFile);
//                 //             fileInput.files = dataTransfer.files;
//                 //             $('#edit #row-warna input[type="file"]').attr(
//                 //                 "data-id",
//                 //                 t?.id
//                 //             );
//                 //         }
//                 //         $("#edit #row-warna").addClass("hadir");
//                 //         $("#edit #row-warna").removeClass("d-none");
//                 //     } else if (this[index] == 10) {
//                 //         $("#edit #row-tb #tb").val(v?.tb);
//                 //         $("#edit #row-tb").addClass("hadir");
//                 //         $("#edit #row-tb").removeClass("d-none");
//                 //     } else if (this[index] == 11) {
//                 //         $("#edit #row-bb #bb").val(v?.bb);
//                 //         $("#edit #row-bb").addClass("hadir");
//                 //         $("#edit #row-bb").removeClass("d-none");
//                 //     } else if (this[index] == 12) {
//                 //         if (this[index] == t?.syarat_id) {
//                 //             const fileInput = document.querySelector(
//                 //                 '#edit #row-hidup input[type="file"]'
//                 //             );
//                 //             const myFile = new File([""], data, {
//                 //                 type: "application/pdf",
//                 //                 lastModified: new Date(),
//                 //             });
//                 //             const dataTransfer = new DataTransfer();
//                 //             dataTransfer.items.add(myFile);
//                 //             fileInput.files = dataTransfer.files;
//                 //             $('#edit #row-hidup input[type="file"]').attr(
//                 //                 "data-id",
//                 //                 t?.id
//                 //             );
//                 //         }
//                 //         $("#edit #row-hidup").addClass("hadir");
//                 //         $("#edit #row-hidup").removeClass("d-none");
//                 //     } else if (this[index] == 13) {
//                 //         if (this[index] == t?.syarat_id) {
//                 //             const fileInput = document.querySelector(
//                 //                 '#edit #row-depan input[type="file"]'
//                 //             );
//                 //             const myFile = new File([""], data, {
//                 //                 type: "application/pdf",
//                 //                 lastModified: new Date(),
//                 //             });
//                 //             const dataTransfer = new DataTransfer();
//                 //             dataTransfer.items.add(myFile);
//                 //             fileInput.files = dataTransfer.files;
//                 //             $('#edit #row-depan input[type="file"]').attr(
//                 //                 "data-id",
//                 //                 t?.id
//                 //             );
//                 //         }
//                 //         $("#edit #row-depan").addClass("hadir");
//                 //         $("#edit #row-depan").removeClass("d-none");
//                 //     }
//                 // }, syarat);
//             });
//         });
//     });
//     return false;
// }

function nl2br(mystr, is_xhtml) {
    var simplebreaktag =
        is_xhtml || typeof is_xhtml === "undefined" ? "<br />" : "<br>";
    return (mystr + "").replace(
        /([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,
        "$1" + simplebreaktag + "$2"
    );
}

function tutup() {
    $("#viewRekt").modal("hide");
    $("#btn-viewBerkas").addClass("collapsed");
    $("#btn-viewBerkas").attr("aria-expanded", "false");
    $("#collapseTwo").removeClass("show");
}

function view(id) {
    $("#viewRekt").modal("show");
    $.each(data, async function (i, v) {
        if (v?.id == id) {
            $("#viewNamaRekt").text(v?.recruitment_name);
            $.each(v?.rekrut, function (x, y) {
                let waktu = y?.clock.split(" ");
                $("#viewTanggal").text(`${waktu[0]} ${waktu[1]} ${waktu[2]}`);
                $("#viewPukul").text(`${waktu[3]} WIB`);
                $("#viewLokasi").html(nl2br(`${y?.location}`));
                $("#viewDeskripsi").html(nl2br(`${y?.description}`));
            });
            if (v?.status_berkas == 1) {
                $("#viewRekt #alasan").addClass("d-none");
                $("#viewRekt #viewAlasan").text("");
                $("#viewStatusBerkas").html(
                    `<span class="badge bg-warning text-dark">Proses Pemeriksaan</span>`
                );
            } else if (v?.status_berkas == 2) {
                $("#viewRekt #alasan").addClass("d-none");
                $("#viewRekt #viewAlasan").text("");
                $("#viewStatusBerkas").html(
                    `<span class="badge bg-success">Sudah Lengkap</span>`
                );
            } else if (v?.status_berkas == 3) {
                $("#viewRekt #alasan").removeClass("d-none");
                $("#viewRekt #viewAlasan").text(v?.alasan_berkasTidakLengkap);
                $("#viewStatusBerkas").html(
                    `<span class="badge bg-danger">Belum Lengkap</span>`
                );
            }

            // if (v?.tb != null) {
            //     $("#tb").removeClass("d-none");
            //     $("#viewTB").text(v?.tb + " cm");
            // } else if (v?.tb == null) {
            //     $("#tb").addClass("d-none");
            // }

            // if (v?.bb != null) {
            //     $("#bb").removeClass("d-none");
            //     $("#viewBB").text(v?.bb + " kg");
            // } else if (v?.bb == null) {
            //     $("#bb").addClass("d-none");
            // }

            //berkas
            let data_peserta = v?.berkas;
            let html = ``;
            let berkas_diri = v?.berkas_diri;
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
                                            <img src="${baseUrl}storage/${element?.attachment}" class="card-img-top" style="height:9rem;object-fit:cover;" alt="...">
                                            <div class="card-body" style="padding: 0px 10px 10px 10px;">
                                                <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">${response.data[i]?.syarat}</h6>
                                                <button type="button" onclick="unduh(${element?.id})" id="dw-${element?.id}" data-ekstension="${element?.attachment}" data-file="${response.data[i]?.syarat}" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                                } else if (file[1] == "jpeg") {
                                    html += `
                                    <div class="col-md-4">
                                        <div class="card">
                                            <img src="${baseUrl}storage/${element?.attachment}" class="card-img-top" style="height:9rem;object-fit:cover;" alt="...">
                                            <div class="card-body" style="padding: 0px 10px 10px 10px;">
                                                <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">${response.data[i]?.syarat}</h6>
                                                <button type="button" onclick="unduh(${element?.id})" id="dw-${element?.id}" data-ekstension="${element?.attachment}" data-file="${response.data[i]?.syarat}" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></button>
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
                                                <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">${response.data[i]?.syarat}</h6>
                                                <button type="button" onclick="unduh(${element?.id})" id="dw-${element?.id}" data-ekstension="${element?.attachment}" data-file="${response.data[i]?.syarat}" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                                } else if (file[1] == "png") {
                                    html += `
                                    <div class="col-md-4">
                                        <div class="card">
                                            <img src="${baseUrl}storage/${element?.attachment}" class="card-img-top" style="height:9rem;object-fit:cover;" alt="...">
                                            <div class="card-body" style="padding: 0px 10px 10px 10px;">
                                                <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">${response.data[i]?.syarat}</h6>
                                                <button type="button" onclick="unduh(${element?.id})" id="dw-${element?.id}" data-ekstension="${element?.attachment}" data-file="${response.data[i]?.syarat}" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></button>
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
            //                 <img src="${baseUrl}storage/${element?.attachment}" class="card-img-top" style="height:9rem;object-fit:cover;" alt="...">
            //                 <div class="card-body" style="padding: 0px 10px 10px 10px;">
            //                     <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">${title}</h6>
            //                     <button type="button" onclick="unduh(${element?.id})" id="dw-${element?.id}" data-ekstension="${element?.attachment}" data-file="${title}" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></button>
            //                 </div>
            //             </div>
            //         </div>
            //         `;
            //     } else if (file[1] == "jpeg") {
            //         html += `
            //         <div class="col-md-4">
            //             <div class="card">
            //                 <img src="${baseUrl}storage/${element?.attachment}" class="card-img-top" style="height:9rem;object-fit:cover;" alt="...">
            //                 <div class="card-body" style="padding: 0px 10px 10px 10px;">
            //                     <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">${title}</h6>
            //                     <button type="button" onclick="unduh(${element?.id})" id="dw-${element?.id}" data-ekstension="${element?.attachment}" data-file="${title}" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></button>
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
            //                     <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">${title}</h6>
            //                     <button type="button" onclick="unduh(${element?.id})" id="dw-${element?.id}" data-ekstension="${element?.attachment}" data-file="${title}" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></button>
            //                 </div>
            //             </div>
            //         </div>
            //         `;
            //     } else if (file[1] == "png") {
            //         html += `
            //         <div class="col-md-4">
            //             <div class="card">
            //                 <img src="${baseUrl}storage/${element?.attachment}" class="card-img-top" style="height:9rem;object-fit:cover;" alt="...">
            //                 <div class="card-body" style="padding: 0px 10px 10px 10px;">
            //                     <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">${title}</h6>
            //                     <button type="button" onclick="unduh(${element?.id})" id="dw-${element?.id}" data-ekstension="${element?.attachment}" data-file="${title}" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></button>
            //                 </div>
            //             </div>
            //         </div>
            //         `;
            //     }
            // });
            // $("#berkas").html(html);
        }
    });
}

function unduh(id) {
    let extension = $("#dw-" + id + "")
        .attr("data-ekstension")
        .split(".");
    //
    let dataFileName = $("#dw-" + id + "").attr("data-file");
    let namaUser = localStorage.getItem("name");
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

function edit(id) {
    $("#edit").modal("show");
    $.each(data, async function (i, v) {
        if (v?.id == id) {
            dataRektId = v?.recruitment_id;
            dataRektName = v?.recruitment_name;
            $("#edit #nama").val(v?.name_user);
            $("#edit #noHp").val(v?.phone);
            $("#edit #alamat").val(v?.address);
            $("#edit #email").val(v?.email);

            let html = ``;
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
                    $.each(v?.berkas_diri, function (index, element) {
                        for (let i = 0; i < response.data.length; i++) {
                            if (element?.syarat_id == response.data[i]?.id) {
                                if (
                                    response.data[i]?.type == "text" &&
                                    response.data[i]?.format == null
                                ) {
                                    html = `
                                        <div class="mb-3 hadir" id="row-${response.data[i]?.id}">
                                            <label for="berkas-${response.data[i]?.id}" class="form-label">${response.data[i]?.syarat}</label>
                                            <input type="text" class="form-control input-berkas input-berkas-teks" name="${response.data[i]?.id}" data-title="${response.data[i]?.syarat}" data-id="${element?.id}" id="berkas-${response.data[i]?.id}" placeholder="Masukan ${response.data[i]?.syarat}" value="${element?.value}">
                                        </div>
                                        `;
                                }
                                break;
                            }
                        }
                        $("#edit #formberkas").append(html);
                    }),
                    $.each(v?.berkas, function (s, t) {
                        let dataSyarat = [];
                        for (let i = 0; i < response.data.length; i++) {
                            //list kualifikasi
                            if (t?.syarat_id == response.data[i]?.id) {
                                // part = response.data[i]?.syarat;
                                dataSyarat.push({
                                    namaFile: t?.originalName,
                                    idSyarat: response.data[i]?.id,
                                    typeSyarat: response.data[i]?.type,
                                    formatSyarat: response.data[i]?.format,
                                });
                                if (
                                    response.data[i]?.type == "file" &&
                                    response.data[i]?.format == "pdf"
                                ) {
                                    html = `
                                        <div class="mb-3 hadir" id="row-${response.data[i]?.id}">
                                            <label for="berkas-${response.data[i]?.id}" class="form-label">${response.data[i]?.syarat}</label>
                                            <input type="file" class="form-control input-berkas file" name="${response.data[i]?.id}" data-title="${response.data[i]?.syarat}" data-id="${t?.id}" id="berkas-${response.data[i]?.id}" accept=".pdf">
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
                                                    <input type="file" class="form-control d-none input-berkas gambar" name="${response.data[i]?.id}" data-title="${response.data[i]?.syarat}" data-id="${t?.id}" id="berkas-${response.data[i]?.id}" accept="image/png, image/jpg, image/jpeg">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="" class="form-label">Preview</label>
                                                <img class="img-upload-rekrutmen" id="pict-${response.data[i]?.id}" src="${baseUrl}storage/${t?.attachment}" alt="">
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
                                            <input type="text" class="form-control input-berkas input-berkas-teks" name="${response.data[i]?.id}" data-title="${response.data[i]?.syarat}" data-id="${t?.id}" id="berkas-${response.data[i]?.id}" placeholder="Masukan ${response.data[i]?.syarat}">
                                        </div>
                                        `;
                                }
                                break;
                            }
                        }
                        $("#edit #formberkas").append(html);
                        for (let i = 0; i < dataSyarat.length; i++) {
                            if (
                                dataSyarat[i]?.typeSyarat == "file" &&
                                dataSyarat[i]?.formatSyarat == "pdf"
                            ) {
                                const fileInput = document.querySelector(
                                    "#edit #row-" +
                                        dataSyarat[i]?.idSyarat +
                                        " input[type='file']"
                                );
                                const myFile = new File(
                                    [""],
                                    dataSyarat[i]?.namaFile,
                                    {
                                        type: "application/pdf",
                                    }
                                );
                                const dataTransfer = new DataTransfer();
                                dataTransfer.items.add(myFile);
                                fileInput.files = dataTransfer.files;
                            } else if (
                                dataSyarat[i]?.typeSyarat == "file" &&
                                dataSyarat[i]?.formatSyarat == "png,jpeg,jpg"
                            ) {
                                const fileInput = document.querySelector(
                                    "#edit #row-" +
                                        dataSyarat[i]?.idSyarat +
                                        " input[type='file']"
                                );
                                const myFile = new File(
                                    [""],
                                    dataSyarat[i]?.namaFile,
                                    {
                                        type: "image/*",
                                        lastModified: new Date(),
                                    }
                                );
                                const dataTransfer = new DataTransfer();
                                dataTransfer.items.add(myFile);
                                fileInput.files = dataTransfer.files;
                            }
                        }

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
            } catch (error) {
                handleErrorSimpan(error);
            }
            // $.each(v?.berkas, function (s, t) {
            //     let data = t?.originalName;
            //
            // if (t?.syarat_id == 1) {
            //     const fileInput = document.querySelector(
            //         '#edit #row-lamaran input[type="file"]'
            //     );
            //     const myFile = new File([""], data, {
            //         type: "application/pdf",
            //         lastModified: new Date(),
            //     });
            //     const dataTransfer = new DataTransfer();
            //     dataTransfer.items.add(myFile);
            //     fileInput.files = dataTransfer.files;
            //     $('#edit #row-lamaran input[type="file"]').attr(
            //         "data-id",
            //         t?.id
            //     );
            //     $("#edit #row-lamaran").addClass("hadir");
            //     $("#edit #row-lamaran").removeClass("d-none");
            // } else if (t?.syarat_id == 2) {
            //     const fileInput = document.querySelector(
            //         '#edit #row-cv input[type="file"]'
            //     );
            //     const myFile = new File([""], data, {
            //         type: "application/pdf",
            //         lastModified: new Date(),
            //     });
            //     const dataTransfer = new DataTransfer();
            //     dataTransfer.items.add(myFile);
            //     fileInput.files = dataTransfer.files;
            //     $('#edit #row-cv input[type="file"]').attr(
            //         "data-id",
            //         t?.id
            //     );
            //     $("#edit #row-cv").addClass("hadir");
            //     $("#edit #row-cv").removeClass("d-none");
            // } else if (t?.syarat_id == 3) {
            //     const fileInput = document.querySelector(
            //         '#edit #row-foto input[type="file"]'
            //     );
            //     const myFile = new File([""], data, {
            //         type: "image/*",
            //         lastModified: new Date(),
            //     });
            //     const dataTransfer = new DataTransfer();
            //     dataTransfer.items.add(myFile);
            //     fileInput.files = dataTransfer.files;
            //     $('#edit #row-foto input[type="file"]').attr(
            //         "data-id",
            //         t?.id
            //     );
            //     $("#edit #row-foto #blah_pas").attr(
            //         "src",
            //         `${baseUrl}storage/${t?.attachment}`
            //     );
            //     $("#edit #row-foto").addClass("hadir");
            //     $("#edit #row-foto").removeClass("d-none");
            // } else if (t?.syarat_id == 4) {
            //     const fileInput = document.querySelector(
            //         '#edit #row-full input[type="file"]'
            //     );
            //     const myFile = new File([""], data, {
            //         type: "image/*",
            //         lastModified: new Date(),
            //     });
            //     const dataTransfer = new DataTransfer();
            //     dataTransfer.items.add(myFile);
            //     fileInput.files = dataTransfer.files;
            //     $('#edit #row-full input[type="file"]').attr(
            //         "data-id",
            //         t?.id
            //     );
            //     $("#edit #row-full #blah_full").attr(
            //         "src",
            //         `${baseUrl}storage/${t?.attachment}`
            //     );
            //     $("#edit #row-full").addClass("hadir");
            //     $("#edit #row-full").removeClass("d-none");
            // } else if (t?.syarat_id == 5) {
            //     const fileInput = document.querySelector(
            //         '#edit #row-ijazah input[type="file"]'
            //     );
            //     const myFile = new File([""], data, {
            //         type: "application/pdf",
            //         lastModified: new Date(),
            //     });
            //     const dataTransfer = new DataTransfer();
            //     dataTransfer.items.add(myFile);
            //     fileInput.files = dataTransfer.files;
            //     $('#edit #row-ijazah input[type="file"]').attr(
            //         "data-id",
            //         t?.id
            //     );
            //     $("#edit #row-ijazah").addClass("hadir");
            //     $("#edit #row-ijazah").removeClass("d-none");
            // } else if (t?.syarat_id == 6) {
            //     const fileInput = document.querySelector(
            //         '#edit #row-skhun input[type="file"]'
            //     );

            //     const myFile = new File([""], data, {
            //         type: "application/pdf",
            //         lastModified: new Date(),
            //     });
            //     const dataTransfer = new DataTransfer();
            //     dataTransfer.items.add(myFile);
            //     fileInput.files = dataTransfer.files;
            //     $('#edit #row-skhun input[type="file"]').attr(
            //         "data-id",
            //         t?.id
            //     );
            //     $("#edit #row-skhun").addClass("hadir");
            //     $("#edit #row-skhun").removeClass("d-none");
            // } else if (t?.syarat_id == 7) {
            //     const fileInput = document.querySelector(
            //         '#edit #row-raport input[type="file"]'
            //     );
            //     const myFile = new File([""], data, {
            //         type: "application/pdf",
            //         lastModified: new Date(),
            //     });
            //     const dataTransfer = new DataTransfer();
            //     dataTransfer.items.add(myFile);
            //     fileInput.files = dataTransfer.files;
            //     $('#edit #row-raport input[type="file"]').attr(
            //         "data-id",
            //         t?.id
            //     );
            //     $("#edit #row-raport").addClass("hadir");
            //     $("#edit #row-raport").removeClass("d-none");
            // } else if (t?.syarat_id == 8) {
            //     const fileInput = document.querySelector(
            //         '#edit #row-sehat input[type="file"]'
            //     );
            //     const myFile = new File([""], data, {
            //         type: "application/pdf",
            //         lastModified: new Date(),
            //     });
            //     const dataTransfer = new DataTransfer();
            //     dataTransfer.items.add(myFile);
            //     fileInput.files = dataTransfer.files;
            //     $('#edit #row-sehat input[type="file"]').attr(
            //         "data-id",
            //         t?.id
            //     );
            //     $("#edit #row-sehat").addClass("hadir");
            //     $("#edit #row-sehat").removeClass("d-none");
            // } else if (t?.syarat_id == 9) {
            //     const fileInput = document.querySelector(
            //         '#edit #row-warna input[type="file"]'
            //     );
            //     const myFile = new File([""], data, {
            //         type: "application/pdf",
            //         lastModified: new Date(),
            //     });
            //     const dataTransfer = new DataTransfer();
            //     dataTransfer.items.add(myFile);
            //     fileInput.files = dataTransfer.files;
            //     $('#edit #row-warna input[type="file"]').attr(
            //         "data-id",
            //         t?.id
            //     );
            //     $("#edit #row-warna").addClass("hadir");
            //     $("#edit #row-warna").removeClass("d-none");
            // } else if (t?.syarat_id == 12) {
            //     const fileInput = document.querySelector(
            //         '#edit #row-hidup input[type="file"]'
            //     );
            //     const myFile = new File([""], data, {
            //         type: "application/pdf",
            //         lastModified: new Date(),
            //     });
            //     const dataTransfer = new DataTransfer();
            //     dataTransfer.items.add(myFile);
            //     fileInput.files = dataTransfer.files;
            //     $('#edit #row-hidup input[type="file"]').attr(
            //         "data-id",
            //         t?.id
            //     );
            //     $("#edit #row-hidup").addClass("hadir");
            //     $("#edit #row-hidup").removeClass("d-none");
            // } else if (t?.syarat_id == 13) {
            //     const fileInput = document.querySelector(
            //         '#edit #row-depan input[type="file"]'
            //     );
            //     const myFile = new File([""], data, {
            //         type: "application/pdf",
            //         lastModified: new Date(),
            //     });
            //     const dataTransfer = new DataTransfer();
            //     dataTransfer.items.add(myFile);
            //     fileInput.files = dataTransfer.files;
            //     $('#edit #row-depan input[type="file"]').attr(
            //         "data-id",
            //         t?.id
            //     );
            //     $("#edit #row-depan").addClass("hadir");
            //     $("#edit #row-depan").removeClass("d-none");
            // }

            // if (v?.tb != null) {
            //     $("#edit #row-tb #tb").val(v?.tb);
            //     $("#edit #row-tb").addClass("hadir");
            //     $("#edit #row-tb").removeClass("d-none");
            // }
            // if (v?.bb != null) {
            //     $("#edit #row-bb #bb").val(v?.bb);
            //     $("#edit #row-bb").addClass("hadir");
            //     $("#edit #row-bb").removeClass("d-none");
            // }
            // });
        }
    });

    // return false;
    $("#ubah").on("click", function () {
        //
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
                let idInput = $("#syarat")
                    .find(`div.hadir:eq(${i})`)
                    .attr("id");
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
                //     $("#syarat").find(`div.hadir:eq(${i}) #pas_foto`).length ==
                //         1 &&
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
                //     $("#syarat").find(`div.hadir:eq(${i}) #surat_lamaran`)
                //         .length == 1 &&
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
                //     $("#syarat").find(`div.hadir:eq(${i}) #ijazah`).length ==
                //         1 &&
                //     $("#syarat").find("div.hadir #ijazah").val() == ""
                // ) {
                //     emptyData.push({
                //         message:
                //             "Berkas ijazah wajib di isi, dan format yang di perbolehkan .pdf",
                //     });
                // } else if (
                //     $("#syarat").find(`div.hadir:eq(${i}) #skhun`).length ==
                //         1 &&
                //     $("#syarat").find("div.hadir #skhun").val() == ""
                // ) {
                //     emptyData.push({
                //         message:
                //             "Berkas SKHUN wajib di isi, dan format yang di perbolehkan .pdf",
                //     });
                // } else if (
                //     $("#syarat").find(`div.hadir:eq(${i}) #raport`).length ==
                //         1 &&
                //     $("#syarat").find("div.hadir #raport").val() == ""
                // ) {
                //     emptyData.push({
                //         message:
                //             "Berkas nilai raport wajib di isi, dan format yang di perbolehkan .pdf",
                //     });
                // } else if (
                //     $("#syarat").find(`div.hadir:eq(${i}) #sk_sehat`).length ==
                //         1 &&
                //     $("#syarat").find("div.hadir #sk_sehat").val() == ""
                // ) {
                //     emptyData.push({
                //         message:
                //             "Berkas surat keterangan sehat wajib di isi, dan format yang di perbolehkan .pdf",
                //     });
                // } else if (
                //     $("#syarat").find(`div.hadir:eq(${i}) #buta_warna`)
                //         .length == 1 &&
                //     $("#syarat").find("div.hadir #buta_warna").val() == ""
                // ) {
                //     emptyData.push({
                //         message:
                //             "Berkas tidak buta warna wajib di isi, dan format yang di perbolehkan .pdf",
                //     });
                // } else if (
                //     $("#syarat").find(`div.hadir:eq(${i}) #essay_hidup`)
                //         .length == 1 &&
                //     $("#syarat").find("div.hadir #essay_hidup").val() == ""
                // ) {
                //     emptyData.push({
                //         message:
                //             "Berkas essay tentang pengalaman hidup wajib di isi, dan format yang di perbolehkan .pdf",
                //     });
                // } else if (
                //     $("#syarat").find(`div.hadir:eq(${i}) #essay_depan`)
                //         .length == 1 &&
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
                        syarat_id: $(`input[type='file']:eq(${i})`).attr(
                            "name"
                        ),
                        attachment: $(`input[type='file']:eq(${i})`).val()
                            ? $(`input[type='file']:eq(${i})`)[0].files[0]
                            : "",
                        idFile: $(`input[type='file']:eq(${i})`).attr(
                            "data-id"
                        ),
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
                        idValue: $(".input-berkas-teks:eq(" + i + ")").attr(
                            "data-id"
                        ),
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
                form_Data.append(`dataFile[${i}][idFile]`, dataFile[i]?.idFile);
            });

            $.each(dataDiri, function (i, v) {
                form_Data.append(`dataDiri[${i}][value]`, dataDiri[i]?.value);
                form_Data.append(
                    `dataDiri[${i}][syarat_id]`,
                    dataDiri[i]?.syarat_id
                );
                form_Data.append(
                    `dataDiri[${i}][idValue]`,
                    dataDiri[i]?.idValue
                );
            });

            form_Data.append("recruitment_id", dataRektId);
            form_Data.append("recruitment_name", dataRektName);
            form_Data.append("user_id", localStorage.getItem("user"));
            form_Data.append("name_user", $("#nama").val());
            form_Data.append("phone", $("#noHp").val());
            form_Data.append("address", $("#alamat").val());
            form_Data.append("email", $("#email").val());
            // form_Data.append("tb", $("#tb").val());
            // form_Data.append("bb", $("#bb").val());
        }
        loadStart();
        $.ajax({
            url: `${urlApi}participants/update/${id}`,
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
                loadStop();
                Swal.fire({
                    title: "Berhasil!",
                    text: response.status.message,
                    icon: "success",
                    allowOutsideClick: false,
                }).then((result) => {
                    window.location = `${baseUrl}history`;
                });
            },
            error: function (xhr) {
                loadStop();
            },
        });
        return false;
    });
}

function tutupEdit() {
    $("#edit").modal("hide");
    $("#btn-edit-coll").addClass("collapsed");
    $("#btn-edit-coll").attr("aria-expanded", "false");
    $("#syarat").removeClass("show");
    $("#edit #formberkas").empty();
}

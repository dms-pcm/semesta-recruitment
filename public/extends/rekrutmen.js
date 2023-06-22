let data = "";
jQuery(document).ready(function () {
    $("#nav-rekrutmen").removeClass("collapsed");
    showTable();
    preview();
    previewEdit();
    getSyarat();
    $("#inputPukul").datetimepicker({
        format: "DD MMMM YYYY HH:mm",
        icons: {
            time: "bi bi-clock",
            date: "bi bi-calendar",
            up: "bi bi-chevron-up",
            down: "bi bi-chevron-down",
            previous: "bi bi-chevron-left",
            next: "bi bi-chevron-right",
            today: "bi bi-check",
            clear: "bi bi-trash",
            close: "bi bi-times",
        },
    });

    $(".add").click(function () {
        if ($(this).prev().val()) {
            $(this)
                .prev()
                .val(+$(this).prev().val() + 1);
        }
        if ($(this).prev().val() == "") {
            $(this)
                .prev()
                .val(+$(this).prev().val() + 1);
        }
    });
    $(".sub").click(function () {
        if ($(this).next().val() == "") {
            $(this)
                .next()
                .val(+$(this).next().val() + 1);
        }
        if ($(this).next().val() > 1) {
            if ($(this).next().val() > 1)
                $(this)
                    .next()
                    .val(+$(this).next().val() - 1);
        }
    });
});

function loadStart() {
    $(".loader").css("display", "flex");
}

function loadStop() {
    $(".loader").css("display", "none");
}

function preview() {
    inputGambar.onchange = (evt) => {
        const [file] = inputGambar.files;
        if (file) {
            blah.src = URL.createObjectURL(file);
        }
    };
}

function previewEdit() {
    editGambar.onchange = (evt) => {
        const [file] = editGambar.files;
        if (file) {
            preview_edit.src = URL.createObjectURL(file);
        }
    };
}

function nl2br(mystr, is_xhtml) {
    var simplebreaktag =
        is_xhtml || typeof is_xhtml === "undefined" ? "<br />" : "<br>";
    return (mystr + "").replace(
        /([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,
        "$1" + simplebreaktag + "$2"
    );
}

function textAreaAdjust(element) {
    element.style.height = "1px";
    element.style.height = 3 + element.scrollHeight + "px";
}

function tutup() {
    $("#buatJadwal").modal("hide");
    $("#buatJadwal #inputJudul").val("");
    $("#buatJadwal #inputPukul").val("");
    $("#buatJadwal #inputLokasi").val("");
    $("#buatJadwal #blah").attr("src", `${baseUrl}/be/assets/img/no_image.png`);
    $("#buatJadwal #inputPersyaratan").val("");
    $(".selectpicker").selectpicker("refresh");
    $("#buatJadwal #inputDeskripsi").val("");
}

function getSyarat() {
    $.ajax({
        url: `${urlApi}recruitments/syarat`,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        success: function (response) {
            $.each(response?.data, function (index, element) {
                $("#buatJadwal #inputPersyaratan").append(
                    '<option value="' +
                        element?.id +
                        '">' +
                        element?.syarat +
                        "</option>"
                );
                $(".selectpicker").selectpicker("refresh");
            });
            $.each(response?.data, function (index, element) {
                $("#editJadwal #editPersyaratan").append(
                    '<option value="' +
                        element?.id +
                        '">' +
                        element?.syarat +
                        "</option>"
                );
                $(".selectpicker").selectpicker("refresh");
            });
        },
        error: function (xhr) {
            handleErrorSimpan(xhr);
        },
    });
}

function showTable() {
    $("#tbl-rekrutmen").DataTable({
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
            url: `${urlApi}recruitments`,
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
                    <tr class="odd"><td colspan="8" class="dataTables_empty" valign="top">Tidak ditemukan data yang cocok</td></tr>
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
                data: "title",
                name: "title",
            },
            {
                data: "description",
                render: function (data, type, row) {
                    let result =
                        data.length > 110 ? data.slice(0, 110) + "..." : data;
                    return nl2br(`${result}`);
                },
            },
            {
                data: "clock",
                orderable: true,
                searchable: true,
                render: function (data, type, row) {
                    let waktu = data.split(" ");
                    return `${waktu[0]} ${waktu[1]} ${waktu[2]}`;
                },
            },
            {
                data: "clock",
                orderable: true,
                searchable: true,
                render: function (data, type, row) {
                    let waktu = data.split(" ");
                    return `${waktu[3]} WIB`;
                },
            },
            {
                data: "quantity",
                render: function (data, type, row) {
                    return `${data} peserta <a href="${baseUrl}be-admin/data-peserta?${row?.id}" title="lihat peserta"><i class="bi bi-eye"></i></a>`;
                },
            },
            {
                data: "status_recruitment",
                render: function (data, type, row) {
                    if (data == 0) {
                        return `<span class="badge bg-success">Sudah Selesai</span>`;
                    } else if (data == 1) {
                        return `<span class="badge bg-warning">Belum Selesai</span>`;
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

function addRecruitment() {
    var formData = new FormData(document.getElementById("recruitment"));
    if ($("input[type='file']")[0].files[0] == undefined) {
        formData.append("title", $("#inputJudul").val());
        formData.append("clock", $("#inputPukul").val());
        formData.append("location", $("#inputLokasi").val());
        formData.append("persyaratan", $("#inputPersyaratan").val());
        formData.append("company", $("#inputCompany").val());
        formData.append("quantity", $("#quantity-peserta").val());
        formData.append("description", $("#inputDeskripsi").val());
    } else {
        formData.append("title", $("#inputJudul").val());
        formData.append("clock", $("#inputPukul").val());
        formData.append("location", $("#inputLokasi").val());
        formData.append("attachment", $("input[type='file']")[0].files[0]);
        formData.append("persyaratan", $("#inputPersyaratan").val());
        formData.append("company", $("#inputCompany").val());
        formData.append("quantity", $("#quantity-peserta").val());
        formData.append("description", $("#inputDeskripsi").val());
    }
    loadStart();
    $.ajax({
        url: `${urlApi}recruitments/create`,
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
                    window.location = `${baseUrl}be-admin/rekrutmen`;
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

function viewDetail(id) {
    $("#viewJadwal").modal("show");
    $.ajax({
        url: `${urlApi}recruitments/detail/${id}`,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        success: async function (response) {
            let res = response?.data;
            $("#viewJudul").text(`${res?.title}`);
            $("#viewCompany").text(`${res?.company}`);
            let waktu = res?.clock.split(" ");
            $("#viewTanggal").text(`${waktu[0]} ${waktu[1]} ${waktu[2]}`);
            $("#viewPukul").text(`${waktu[3]} WIB`);
            $("#viewLokasi").html(nl2br(`${res?.location}`));
            let syarat = res?.persyaratan;
            let data = [];
            try {
                const response = await $.ajax({
                    url: `${urlApi}persyaratan/show`,
                    type: "GET",
                });
                await Promise.all(
                    syarat.map(async (part, index) => {
                        for (let i = 0; i < response.data.length; i++) {
                            //list kualifikasi
                            if (part?.persyaratan_id == response.data[i]?.id) {
                                part = response.data[i]?.syarat;
                                break;
                            }
                        }
                        data.push(part);
                    })
                );
            } catch (error) {
                handleErrorSimpan(error);
            }
            // syarat.forEach(function (part, index) {
            //     if (part?.persyaratan_id == 1) {
            //         part = "Surat Lamaran";
            //     } else if (part?.persyaratan_id == 2) {
            //         part = "CV";
            //     } else if (part?.persyaratan_id == 3) {
            //         part = "Pas Foto";
            //     } else if (part?.persyaratan_id == 4) {
            //         part = "Foto Full Body";
            //     } else if (part?.persyaratan_id == 5) {
            //         part = "Ijazah";
            //     } else if (part?.persyaratan_id == 6) {
            //         part = "SKHUN";
            //     } else if (part?.persyaratan_id == 7) {
            //         part = "Nilai Raport";
            //     } else if (part?.persyaratan_id == 8) {
            //         part = "Surat Keterangan Sehat";
            //     } else if (part?.persyaratan_id == 9) {
            //         part = "Tidak Buta Warna";
            //     } else if (part?.persyaratan_id == 10) {
            //         part = "Tinggi Badan";
            //     } else if (part?.persyaratan_id == 11) {
            //         part = "Berat Badan";
            //     } else if (part?.persyaratan_id == 12) {
            //         part = "Essay Tentang Pengalaman Hidup";
            //     } else if (part?.persyaratan_id == 13) {
            //         part = "Essay Tentang Target Masa Depan";
            //     }
            //     data.push(part);
            // }, syarat);
            $("#viewPersyaratan").text(data.toString());
            $("#viewQuantity").text(`${res?.quantity} peserta`);
            $("#viewDeskripsi").html(nl2br(`${res?.description}`));
            $("#viewFoto").html(`
            <span class="text-foto">Klik gambar untuk melihat flayer rekrutmen!</span><a href="${baseUrl}storage/${res?.attachment}" title="Flayer ${res?.title}" data-fancybox="gallery"
					data-caption="Flayer ${res?.title}"><img src="${baseUrl}storage/${res?.attachment}" class="img-view-rekrutmen" alt="Flayer ${res?.title}"></img></a>
            `);
        },
        error: function (xhr) {
            handleErrorSimpan(xhr);
        },
    });
}

function editRekrutmen(id) {
    $("#editJadwal").modal("show");
    let flayer = "";
    let idRect = "";
    $.each(data, function (index, element) {
        if (element?.id == id) {
            $("#editJadwal #editJudul").val(element?.title);
            $("#editJadwal #editCompany").val(element?.company);
            $("#editJadwal #editPukul").val(element?.clock);
            $("#editJadwal #editLokasi").val(element?.location);
            $("#editJadwal #preview_edit").attr(
                "src",
                `${baseUrl}storage/${element?.attachment}`
            );
            let syarat = element?.persyaratan;
            let dataSyarat = [];
            syarat.forEach(function (part, index) {
                dataSyarat.push(part?.persyaratan_id);
            }, syarat);
            $("select[name=valueSyarat]").val(dataSyarat);
            $(".selectpicker").selectpicker("refresh");
            $("#editJadwal #edit-quantity-peserta").val(element?.quantity);
            $("#editJadwal #editDeskripsi").val(element?.description);
            flayer = element?.attachment;
            idRect = element?.id;
        }
    });

    $("#editJadwal #btn-ubah").on("click", function () {
        var formData = new FormData();
        let basedView = $("#editJadwal #preview_edit").attr("src");
        let basedDB = `${baseUrl}storage/${flayer}`;
        if (basedView == basedDB) {
            //not change picture
            formData.append("title", $("#editJadwal #editJudul").val());
            formData.append("company", $("#editJadwal #editCompany").val());
            formData.append("clock", $("#editJadwal #editPukul").val());
            formData.append("location", $("#editJadwal #editLokasi").val());
            formData.append("id_recruitment", idRect);
            formData.append(
                "persyaratan",
                $("#editJadwal #editPersyaratan").val()
            );
            formData.append(
                "quantity",
                $("#editJadwal #edit-quantity-peserta").val()
            );
            formData.append(
                "description",
                $("#editJadwal #editDeskripsi").val()
            );
        } else {
            formData.append("title", $("#editJadwal #editJudul").val());
            formData.append("company", $("#editJadwal #editCompany").val());
            formData.append("clock", $("#editJadwal #editPukul").val());
            formData.append("location", $("#editJadwal #editLokasi").val());
            formData.append("id_recruitment", idRect);
            formData.append(
                "attachment",
                $("#editJadwal input[type='file']")[0].files[0]
            );
            formData.append(
                "persyaratan",
                $("#editJadwal #editPersyaratan").val()
            );
            formData.append(
                "quantity",
                $("#editJadwal #edit-quantity-peserta").val()
            );
            formData.append(
                "description",
                $("#editJadwal #editDeskripsi").val()
            );
        }
        loadStart();
        $.ajax({
            url: `${urlApi}recruitments/update/${id}`,
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
                        window.location = `${baseUrl}be-admin/rekrutmen`;
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

function deleteRekrutmen(id) {
    Swal.fire({
        title: "Hapus Jadwal Rekrutmen?",
        text: "Apakah anda yakin ingin menghapus jadwal ini!",
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
                url: `${urlApi}recruitments/delete/${id}`,
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
                            window.location = `${baseUrl}be-admin/rekrutmen`;
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

function selesai(id) {
    Swal.fire({
        title: "Rekrutmen selesai terlaksana?",
        text: "Apakah anda yakin rekrutmen ini sudah selesai terlaksana!",
        icon: "warning",
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonColor: "#198754",
        cancelButtonColor: "#acacac",
        cancelButtonText: "Batal",
        confirmButtonText: "Iya, yakin",
    }).then((result) => {
        if (result.isConfirmed) {
            loadStart();
            $.ajax({
                url: `${urlApi}recruitments/done/${id}`,
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
                            window.location = `${baseUrl}be-admin/rekrutmen`;
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

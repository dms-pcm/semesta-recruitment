var handleErrorLogin = function (response) {
    let res = response.responseJSON;
    let code = response.status;

    if (code == 422) {
        let resOther = "";
        if (res.data.errors !== undefined) {
            const entries = Object.entries(res.data.errors);

            for (const [name, errMsg] of entries) {
                resOther += `<br>${errMsg}`;
            }
        } else {
            const entries = Object.entries(res.data);

            for (const [name, errMsg] of entries) {
                resOther += `<br>${errMsg}`;
            }
        }
        Swal.fire(
            "Oopss...",
            res.status.message +
                `<div class="text-center text-muted p-2">` +
                resOther +
                `</div>`,
            "error"
        );
    } else if (code == 401) {
        localStorage.clear();
        delete localStorage.token;
        delete localStorage.user;
        delete localStorage.role;
        delete localStorage.name;
        localStorage.removeItem("type-role");
        Swal.fire("Oopss...", res.status.message, "error").then((result) => {
            window.location = `${baseUrl}login`;
        });
    }
};

var handleErrorDetails = function (response) {
    let res = response.responseJSON;
    let code = response.status;

    if (code == 400) {
        Swal.fire({
            title: "Oopss...",
            icon: "warning",
            text: "Silahkan isi data diri terlebih dahulu",
            showCancelButton: false,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Siap",
            allowOutsideClick: false,
        });
    }
};

var handleErrorSimpan = function (response) {
    let res = response.responseJSON;
    let code = response.status;

    if (code == 422) {
        let resOther = "";
        if (res.data.errors !== undefined) {
            const entries = Object.entries(res.data.errors);

            for (const [name, errMsg] of entries) {
                resOther += `<br>${errMsg}`;
            }
        } else {
            const entries = Object.entries(res.data);

            for (const [name, errMsg] of entries) {
                resOther += `<br>${errMsg}`;
            }
        }
        Swal.fire(
            "Oopss...",
            res.status.message +
                `<div class="text-center text-muted p-2">` +
                resOther +
                `</div>`,
            "error"
        );
    } else if (code == 401) {
        localStorage.clear();
        delete localStorage.token;
        delete localStorage.user;
        delete localStorage.role;
        delete localStorage.name;
        localStorage.removeItem("type-role");
        Swal.fire("Oopss...", res.status.message, "error").then((result) => {
            window.location = `${baseUrl}login`;
        });
    }
};

var handleErrorTable = function (response) {
    let res = response.responseJSON;
    let code = response.status;

    if (code == 500) {
        Swal.fire({
            title: "Oopss...",
            icon: "error",
            text: res.status.message,
            allowOutsideClick: false,
        });
    } else if (code == 422) {
        Swal.fire({
            title: "Oopss...",
            icon: "warning",
            text: res.status.message,
            allowOutsideClick: false,
        });
    } else if (code == 401) {
        localStorage.clear();
        delete localStorage.token;
        delete localStorage.user;
        delete localStorage.role;
        delete localStorage.name;
        localStorage.removeItem("type-role");
        Swal.fire("Oopss...", res.status.message, "error").then((result) => {
            window.location = `${baseUrl}login`;
        });
    }
};

// ######## Start Code Toasty ########
// Toastify({
//     text: res.status.message,
//     duration: 3000,
//     newWindow: true,
//     close: true,
//     gravity: "top", // `top` or `bottom`
//     position: "right", // `left`, `center` or `right`
//     stopOnFocus: true, // Prevents dismissing of toast on hover
//     style: {
//         background:
//             "linear-gradient(to right, rgb(255, 0, 0), rgb(255, 143, 0))",
//         borderRadius: "7px",
//     },
//     onClick: function () {}, // Callback after click
// }).showToast();
// ######## End Code Toasty ########

// ######## Start Code Swal Toast ########
// const Toast = Swal.mixin({
//     toast: true,
//     position: "top-end",
//     showConfirmButton: false,
//     timer: 3000,
//     timerProgressBar: true,
//     didOpen: (toast) => {
//         toast.addEventListener("mouseenter", Swal.stopTimer);
//         toast.addEventListener("mouseleave", Swal.resumeTimer);
//     },
// });

// Toast.fire({
//     icon: "error",
//     title: "Signed in successfully",
// });
// ######## End Code Swal Toast ########

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Semesta recruitment</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <!-- <link href="{{asset('fe/assets/img/bkk-logo.png')}}" rel="icon"> -->
    <!-- <link href="{{asset('fe/assets/img/bkk-logo.png')}}" rel="apple-touch-icon"> -->

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>

    <!-- Vendor CSS Files -->
    <link href="{{asset('fe/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('fe/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('fe/assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('fe/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset('fe/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
    <link href="{{asset('fe/assets/vendor/aos/aos.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('be/assets/vendor/sweetalert/css/sweetalert2.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap5.min.css">

    <!-- Template Main CSS File -->
    <link href="{{asset('fe/assets/css/main.css')}}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        let baseUrl = "{{url('/')}}/";
        let urlApi = "{{url('/api')}}/";
    </script>
</head>

<body>
    <div class="text-center loader justify-content-center align-items-center w-100">
        <div class="bar-load">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
            <div class="bar4"></div>
            <div class="bar5"></div>
            <div class="bar6"></div>
        </div>
    </div>
    <!-- ======= Header ======= -->
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

            <a href="{{url('/')}}" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="{{asset('fe/assets/img/logo.png')}}" alt=""> -->
                <h1>SEMESTA <br><small class="fs-6 d-flex text-center">recruitment</small></h1>
            </a>
            {{--<div class="dropdown">
                <button type="button" class="btn btn-primary dropdown-toggle position-relative" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Inbox
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        99+
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>--}}
            <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a href="{{url('/#hero')}}" id="nav-home">Home</a></li>
                    <li><a href="{{url('/#about')}}" id="nav-about">Tentang Kami</a></li>
                    <li><a href="{{url('/information')}}" id="nav-info">Informasi Rekrutmen</a></li>
                    <li class="dropdown web" id="notif">
                        <a href="#">
                            <i class="bi bi-bell-fill" style="font-size:22px;"></i>
                            <span class="badge bg-primary badge-number count-notif d-none" id="jumlah-notif"></span>
                        </a>
                        <ul class="overflow-auto" style="left:-14rem;max-height:300px;width:300px !important;" id="notifikasi">
                            {{--<li class="notification-item">
                                <a href="#" style="white-space: inherit;padding:0;padding-left: 10px;padding-right: 10px;">
                                    <i class="bi bi-exclamation-circle text-warning"></i>
                                    <div style="margin:0;">
                                        <h4 class="mb-1 mt-2">Lorem Ipsum</h4>
                                        <p class="mb-1" style="word-break: break-all;">Mohon maaf peserta atas nama '.$nama_user.' belum lolos seleksi rekrutmen '.$rekrutmen.'.'</p>
                                        <p class="mb-1">30 min. ago</p>
                                    </div>
                                </a>
                            </li>--}}
                        </ul>
                    </li>
                    <li class="dropdown" id="account"><a href="#"><img id="foto" src="{{asset('be/assets/img/default-profile.jpg')}}" class="rounded-circle" style="object-fit:cover;border: 2px solid white;" width="27" height="27" alt="Profil">&nbsp;<span class="nama-user">User</span> 
                        <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                        <ul>
                            <li><a href="{{url('/profile')}}">Profile</a></li>
                            <!-- <li><a href="{{url('/account-setting')}}">Setting Akun</a></li> -->
                            <li><a href="{{url('/history')}}">Riwayat Rekrutmen</a></li>
                            <li><a href="javascript:void(0)" onclick="logout()">Logout</a></li>
                            <!-- <li><a href="#">Drop Down 4</a></li> -->
                        </ul>
                    </li>
                    <li id="link-login"><a href="{{url('/login')}}">Login</a></li>
                </ul>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->
    <!-- End Header -->

    @yield('content')

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-7 col-md-12 footer-info">
                    <a href="{{url('/')}}" class="logo d-flex align-items-center">
                        <h1>SEMESTA <br><small class="fs-6 d-flex text-center">recruitment</small></h1>
                    </a>
                    <p>Bursa Kerja Khusus (BKK) SMK Negeri 1 Tulungagung adalah sebuah lembaga yang dibentuk di Sekolah Menengah Kejuruan Negeri 1 Tulungagung, sebagai unit pelaksana yang memberikan pelayanan dan informasi lowongan kerja, pelaksana pemasaran, penyaluran dan penempatan tenaga kerja, merupakan mitra Dinas Tenaga Kerja dan Transmigrasi.</p>
                    <div class="social-links d-flex mt-4">
                        <a href="javascript:void(0)" id="tw" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="javascript:void(0)" id="fb" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="javascript:void(0)" id="ig" class="instagram"><i class="bi bi-instagram"></i></a>
                        <!-- <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a> -->
                    </div>
                </div>
                <div class="col-lg-2 col-6"></div>
                <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                    <h4>Hubungi Kami</h4>
                    <p>
                        <span class="fw-bold">Tulungagung</span><br>
                        Jl. Raya Boyolangu No.KM 5, Gedang Sewu Selatan, Gedangsewu<br>
                        Kec. Boyolangu, Kabupaten Tulungagung, Jawa Timur 66235 <br><br>
                        <strong>Telepon:</strong> 0355 325853<br>
                        <strong>Email:</strong> smknegeri1tulungagung@gmail.com<br>
                    </p>

                </div>

            </div>
        </div>

        <div class="container mt-4">
            <div class="copyright">
                &copy; Copyright <strong><span>SemestaRecruitment</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                Designed by <a href="#">dimaspcm_</a>
            </div>
        </div>

    </footer><!-- End Footer -->
    <!-- End Footer -->

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{asset('fe/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('fe/assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
    <script src="{{asset('fe/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{asset('fe/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('fe/assets/vendor/aos/aos.js')}}"></script>
    <script src="{{asset('fe/assets/vendor/php-email-form/validate.js')}}"></script>
    <script src="{{asset('be/assets/vendor/sweetalert/js/sweetalert2.all.js')}}"></script>

    <!-- Template Main JS File -->
    <script src="{{asset('fe/assets/js/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap5.min.js"></script>
    <script src="{{asset('extends/fe/configuration.js')}}"></script>
    <script>
        jQuery(document).ready(function () {
            showSosmed();
            if (localStorage.getItem("token") != null) {
                showfoto();
                notifikasi();
                $('#notif').removeClass('d-none');
                $('#account').removeClass('d-none');
                $('#link-login').addClass('d-none');
            } else {
                $('#notif').addClass('d-none');
                $('#account').addClass('d-none');
                $('#link-login').removeClass('d-none');
            }
        });

        function loadStart() {
            $(".loader").css("display", "flex");
        }

        function loadStop() {
            $(".loader").css("display", "none");
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
                },
                error: function (xhr) {
                    setTimeout(function () {
                        loadStop();
                        handleErrorLogin(xhr);
                    }, 1500);
                },
            });
        }

        function showSosmed() {
            $.ajax({
                url: `${urlApi}sosmed`,
                type: "GET",
                success: function (response) {
                    // console.log(response);
                    let res = response?.data[0];
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
                },
                error: function (xhr) {
                    
                },
            });
        }

        function showfoto() {
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
                        $("#foto").attr("src", `${baseUrl}storage/${res?.attachment}`);
                    } else {
                        $("#foto").attr(
                            "src",
                            `${baseUrl}be/assets/img/default-profile.jpg`
                        );
                    }

                    if (!sessionStorage.getItem('cvAlertShown')) {
                        if (res?.cv == null) {
                            Swal.fire({
                                title: "Oopss!",
                                text: 'Anda belum mengunggah CV Anda. Mohon unggah CV Anda sekarang.',
                                icon: "warning",
                            }).then((result) => {
                                window.location = `${baseUrl}profile`;
                            });
                            sessionStorage.setItem('cvAlertShown', true);
                            sessionStorage.setItem('cvAlertShownDate', new Date().toISOString());
                        }
                    } else {
                        var lastAlertShown = new Date(sessionStorage.getItem('cvAlertShownDate'));
                        var now = new Date();
                        var diff = now - lastAlertShown;
                        var daysPassed = Math.floor(diff / (1000 * 60 * 60 * 24));
                        if (daysPassed >= 30) {
                            Swal.fire({
                                title: "Oopss!",
                                text: 'Sudah lebih dari 30 hari sejak Anda terakhir kali mengunggah CV. Mohon unggah CV Anda sekarang.',
                                icon: "warning",
                            });
                            sessionStorage.setItem('cvAlertShownDate', new Date().toISOString());
                        }
                    }

                },
                error: function (xhr) {
                    handleErrorSimpan(xhr);
                },
            });
        }

        function notifikasi() {
            let htmlNotifikasi = ``;
            let htmlNothing = ``;
            let mark = "";
            $.ajax({
                url: `${urlApi}notifications`,
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
                success: function (response) {
                    let dataNotif = response?.data?.notifications;
                    if (response?.data?.count_notifikasi == 0) {
                        $('#jumlah-notif').addClass('d-none');
                    }else{
                        $('#jumlah-notif').removeClass('d-none');
                        $('#jumlah-notif').text(`${response?.data?.count_notifikasi}`);
                    }

                    if (dataNotif.length == 0) {
                        htmlNothing+=`
                        <li class="notification-item">
                            <div style="white-space: inherit;padding:0;padding-left: 10px;padding-right: 10px;font-family:poppins">
                                <img src="{{asset('fe/assets/img/notif.png')}}" alt="" class="img-fluid" style="width:20%;">
                                <span class="text-center text-muted" style="font-size:13px;">Belum ada notifikasi!</span>
                            </div>
                        </li>
                        `;
                        $('#notifikasi').html(htmlNothing);
                    } else {
                        $.each(dataNotif, function (i, v) {
                            mark = v?.id;
                            let read = v?.read_at;
                            let dataTanggal = v?.created_at;
                            let split1 = dataTanggal.split('T');
                            let split2 = split1[0].split('-');
                            let bulan = '';
                            let hasil = '';
                            if (split2[1] == 1) {
                                bulan = 'Januari';
                            } else if (split2[1] == 2) {
                                bulan = 'Februari';
                            } else if (split2[1] == 3) {
                                bulan = 'Maret';
                            } else if (split2[1] == 4) {
                                bulan = 'April';
                            } else if (split2[1] == 5) {
                                bulan = 'Mei';
                            } else if (split2[1] == 6) {
                                bulan = 'Juni';
                            } else if (split2[1] == 7) {
                                bulan = 'Juli';
                            } else if (split2[1] == 8) {
                                bulan = 'Agustus';
                            } else if (split2[1] == 9) {
                                bulan = 'September';
                            } else if (split2[1] == 10) {
                                bulan = 'Oktober';
                            } else if (split2[1] == 11) {
                                bulan = 'November';
                            } else if (split2[1] == 12) {
                                bulan = 'Desember';
                            }
                            hasil = split2[2]+' '+bulan+' '+split2[0];

                            if (!read) {
                                htmlNotifikasi+=`
                                <li class="notification-item" style="background: aliceblue;">
                                    <a href="javascript:void(0)" style="white-space: inherit;padding:0;padding-left: 10px;padding-right: 10px;" onclick="markAsRead('${mark}','${v?.data?.url}')">
                                        <i class="bi bi-exclamation-circle text-warning"></i>
                                        <div style="margin:0;">
                                            <h4 class="mb-1 mt-2">${v?.data?.status}</h4>
                                            <p class="mb-1">${v?.data?.description}</p>
                                            <p class="mb-1">${hasil}</p>
                                        </div>
                                    </a>
                                </li>
                                `;
                            } else {
                                htmlNotifikasi+=`
                                <li class="notification-item">
                                    <a href="${v?.data?.url}"style="white-space: inherit;padding:0;padding-left: 10px;padding-right: 10px;">
                                        <i class="bi bi-exclamation-circle text-warning"></i>
                                        <div style="margin:0;">
                                            <p class="mb-1 mt-2" style="font-size: 14px;">${v?.data?.status}</p>
                                            <p class="mb-1">${v?.data?.description}</p>
                                            <p class="mb-1">${hasil}</p>
                                        </div>
                                    </a>
                                </li>
                                `;
                            }
                            $('#notifikasi').html(
                                `<div style="padding: 10px 25px;padding-top: 0px;">
                                    <span>Notifikasi</span>
                                </div>
                                <hr style="margin:0px;">` + htmlNotifikasi
                            );
                        });
                    }
                },
                error: function (xhr) {
                    handleErrorLogin(xhr);
                },
            });
        }

        function markAsRead(id,url) {
            $.ajax({
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
                data: {
                    id: id,
                },
                url: `${urlApi}notifications/mark`,
                success: function (response) {
                    notifikasi();
                    window.location.href = url;
                    // console.log('asas');
                },
                error: function (xhr) {
                    handleErrorLogin(xhr);
                },
            });
        }
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SEMESTA | RECRUITMENT</title>
    <!-- Favicons -->
    <!-- <link href="{{asset('be/assets/img/favicon.png')}}" rel="icon">
    <link href="{{asset('be/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon"> -->

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('be/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('be/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('be/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('be/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{asset('be/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{asset('be/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{asset('be/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('be/assets/vendor/sweetalert/css/sweetalert2.css')}}">
    <link href="{{asset('be/assets/vendor/datetime-picker/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{asset('be/assets/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        let baseUrl = "{{url('/')}}/";
        let urlApi = "{{url('/api')}}/";
    </script>
</head>
<body>
    <div class="text-center loader justify-content-center align-items-center w-100">
        <!-- <div class="spinner-grow" style="width:3rem; height:3rem; background-color:#00da00;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div> -->
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
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{url('/be-admin/dashboard')}}" class="logo d-flex align-items-center">
                <img src="{{asset('fe/assets/img/bkk.png')}}" style="max-height:38px;" alt="">
                <span class="d-none d-lg-block" style="margin-left:1vw;">SEMESTA <br><small class="fs-6 d-flex text-center">recruitment</small></span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            <!-- <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form> -->
            <span id="date"></span>&nbsp;|&nbsp;<span id="Clock">00:00:00</span>
        </div><!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-calendar2-event"></i>
                    </a>
                </li><!-- End Date Today Icon-->
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number d-none" id="number">4</span>
                    </a><!-- End Notification Icon -->
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" style="max-height: 350px;width:300px;">
                        <li class="dropdown-header" style="padding-top: 0;">
                            <span style="text-align:inherit;font-weight:bolder;font-size: 17px;margin-right: 7rem;">Notifikasi</span>
                            <a href="javascript:void(0)" class="d-none" onclick="markAll()" title="Tandai baca semua" id="baca-semua"><span class="badge rounded-pill bg-primary p-2 ms-2" style="font-size:17px;"><i class="bi bi-check2-all"></i></span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <div class="overflow-auto" style="max-height:300px;" id="notifikasi">
                            {{--<a href="">
                                <li class="notification-item">
                                    <i class="bi bi-exclamation-circle text-warning"></i>
                                    <div>
                                        <h4>Lorem Ipsum</h4>
                                        <p>Quae dolorem earum veritatis oditseno</p>
                                        <p>30 min. ago</p>
                                    </div>
                                </li>
                            </a>
                            <li>
                                <hr class="dropdown-divider">
                            </li>--}}
                        </div>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <!-- <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li> -->
                    </ul><!-- End Notification Dropdown Items -->
                </li><!-- End Notification Nav -->
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="{{asset('be/assets/img/default-profile.jpg')}}" alt="Profile" style="object-fit:cover;" id="foto-circle" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2" id="nama-user"></span>
                    </a><!-- End Profile Iamge Icon -->
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6 id="nama-h6">-</h6>
                            <span>SMK Negeri 1 Tulungagung</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{url('/be-admin/profile')}}">
                                <i class="bi bi-person"></i>
                                <span>Profile Saya</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{url('/be-admin/settings')}}">
                                <i class="bi bi-gear"></i>
                                <span>Akun Setting</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)" onclick="logout()">
                                <!-- <i class="bi bi-box-arrow-right"></i> -->
                                <i class="bi bi-power"></i>
                                <span>Log Out</span>
                            </a>
                        </li>
                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->
            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-heading">Menu</li>

            <li class="nav-item">
                <a class="nav-link collapsed" id="nav-dashboard" href="{{url('/be-admin/dashboard')}}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" id="nav-persyaratan" href="{{url('/be-admin/persyaratan')}}">
                    <i class="bi bi-stickies"></i>
                    <span>Persyaratan</span>
                </a>
            </li><!-- End Rekrutmen Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" id="nav-rekrutmen" href="{{url('/be-admin/rekrutmen')}}">
                    <i class="bi bi-layers-half"></i>
                    <span>Rekrutmen</span>
                </a>
            </li><!-- End Rekrutmen Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" id="nav-peserta" href="{{url('/be-admin/data-peserta')}}">
                    <i class="bi bi-journal-text"></i>
                    <span>Data Peserta</span>
                </a>
            </li><!-- End Data Peserta Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" id="nav-user" href="{{url('/be-admin/data-user')}}">
                    <i class="bi bi-people"></i>
                    <span>Data User</span>
                </a>
            </li><!-- End Data User Nav -->

        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">
        @yield('content') 
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>SemestaRecruitment</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
        Designed by <a href="#">dimaspcm_</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <!-- <script src="{{asset('be/assets/vendor/apexcharts/apexcharts.min.js')}}"></script> -->
    <script src="{{asset('be/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- <script src="{{asset('be/assets/vendor/chart.js/chart.umd.js')}}"></script> -->
    <!-- <script src="{{asset('be/assets/vendor/echarts/echarts.min.js')}}"></script> -->
    <script src="{{asset('be/assets/vendor/quill/quill.min.js')}}"></script>
    <script src="{{asset('be/assets/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('be/assets/vendor/php-email-form/validate.js')}}"></script>
    <script src="{{asset('be/assets/vendor/sweetalert/js/sweetalert2.all.js')}}"></script>

    <!-- Template Main JS File -->
    <script src="{{asset('be/assets/js/main.js')}}"></script>
    <script src="{{asset('be/assets/vendor/datetime-picker/js/moment.min.js')}}"></script>
    <script src="{{asset('be/assets/vendor/datetime-picker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{asset('extends/login.js')}}"></script>
    <script src="{{asset('extends/configuration.js')}}"></script>
    <script>
        jQuery(document).ready(function () {
            if (localStorage.getItem("token") != null) {
                notifikasi();
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
                            $("#foto-circle").attr("src", `${baseUrl}storage/${res?.attachment}`);
                        } else {
                            $("#foto-circle").attr(
                                "src",
                                `${baseUrl}be/assets/img/default-profile.jpg`
                            );
                        }
                        
                        $("#nama-user").text(localStorage.getItem("name"));
                        $("#nama-h6").text(localStorage.getItem("name"));
                        // $("#saha").text(res?.company);
                    },
                    error: function (xhr) {
                        handleErrorSimpan(xhr);
                    },
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Session anda telah berakhir',
                    allowOutsideClick: false,
                }).then((result) => {
                    window.location = `${baseUrl}login`;
                });
            }
            displayTime();
        });

        function displayTime() {
            var monthNames = [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ]; 
            var dayNames= ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];

            var newDate = new Date();
            newDate.setDate(newDate.getDate());
            $('#date').html(dayNames[newDate.getDay()] + ", " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());
            setInterval( function() {
                var hours = new Date().getHours();
                var minutes = new Date().getMinutes();
                var seconds = new Date().getSeconds();
                $("#Clock").html((( hours < 10 ? "0" : "" ) + hours) + ':' + (( minutes < 10 ? "0" : "" ) + minutes) + ':' + (( seconds < 10 ? "0" : "" ) + seconds));
            }, 1000);
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
                    let htmlHeader = "";
                    if (response?.data?.count_notifikasi == 0) {
                        $('#number').addClass('d-none');
                        $('#baca-semua').addClass('d-none');
                    }else{
                        $('#baca-semua').removeClass('d-none');
                        $('#number').removeClass('d-none');
                        $('#number').text(`${response?.data?.count_notifikasi}`);
                    }

                    if (dataNotif.length == 0) {
                        htmlNothing+=`
                        <li class="notification-item">
                            <div style="white-space: inherit;padding:0;padding-left: 10px;padding-right: 10px;font-family:poppins">
                                <img src="{{asset('fe/assets/img/notif.png')}}" alt="" class="img-fluid" style="width:20%;">
                                <span class="text-center text-muted" style="font-size:13px;">Belum ada pemberitahuan!</span>
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
                                <a href="${v?.data?.url}" onclick="markAsRead('${mark}')">
                                    <li class="notification-item" style="background: aliceblue;">
                                        <i class="bi bi-exclamation-circle text-warning"></i>
                                        <div>
                                            <h4>${v?.data?.status}</h4>
                                            <p>${v?.data?.description}</p>
                                            <p>${hasil}</p>
                                        </div>
                                    </li>
                                </a>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                `;
                            } else {
                                htmlNotifikasi+=`
                                <a href="${v?.data?.url}">
                                    <li class="notification-item">
                                        <i class="bi bi-exclamation-circle text-warning"></i>
                                        <div>
                                            <p style="font-size:14px;">${v?.data?.status}</p>
                                            <p>${v?.data?.description}</p>
                                            <p>${hasil}</p>
                                        </div>
                                    </li>
                                </a>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                `;
                            }
                            $('#notifikasi').html(htmlNotifikasi);
                        });
                    }
                },
                error: function (xhr) {
                    handleErrorLogin(xhr);
                },
            });
        }

        function markAsRead(id) {
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
                },
                error: function (xhr) {
                    handleErrorLogin(xhr);
                },
            });
        }

        function markAll() {
            $.ajax({
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
                url: `${urlApi}notifications/markAll`,
                success: function (response) {
                    notifikasi();
                },
                error: function (xhr) {
                    handleErrorLogin(xhr);
                },
            });
        }
    </script>
</body>
</html>
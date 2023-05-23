<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>DAFTAR | RECRUITMENT</title>
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

    <!-- Template Main CSS File -->
    <link href="{{asset('be/assets/css/style.css')}}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        let baseUrl = "{{url('/')}}/";
        let urlApi = "{{url('/api')}}/";
    </script>
</head>
<body>
    <main>
        <div class="text-center loader justify-content-center align-items-center w-100">
            <!-- <div class="spinner-grow" style="width:3rem; height:3rem; background-color:#00da00;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div> -->
            <!-- <span class="text-white title-load" style="font-family:poppins;"> Tunggu Sebentar..</span> -->
            <div class="bar-load">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
                <div class="bar4"></div>
                <div class="bar5"></div>
                <div class="bar6"></div>
            </div>
        </div>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="{{url('/register')}}" class="logo d-flex align-items-center w-auto">
                                    <img src="{{asset('fe/assets/img/bkk.png')}}" style="max-height:42px;" alt="">
                                    <span class="d-none d-lg-block">SEMESTA <small>recruitment</small></span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Buat Akun Baru</h5>
                                        <p class="text-center small text-muted">Masukan beberapa data anda untuk membuat akun</p>
                                    </div>

                                    <form class="row g-3 needs-validation" novalidate>
                                        <div class="col-12">
                                            <label for="yourName" class="form-label">Nama Lengkap Anda <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" id="yourName" required placeholder="cth: Cavero Balmond">
                                            <div class="invalid-feedback">Silahkan masukan nama anda!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourEmail" class="form-label">Email Anda <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control" id="yourEmail" required placeholder="cth: cavero@gmail.com">
                                            <div class="invalid-feedback">Silakan masukkan alamat Email yang valid!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Username <span class="text-danger">*</span></label>
                                            <input type="text" name="username" class="form-control" id="yourUsername" required placeholder="cth: cavero">
                                            <div class="invalid-feedback">Silakan masukan username.</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password <span class="text-danger">*</span></label>
                                            <input type="password" name="password" class="form-control" id="yourPassword" required placeholder="cth: uyiyuutt">
                                            <div class="invalid-feedback">Silahkan masukan password anda!</div>
                                        </div>

                                        <!-- <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                                                <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and conditions</a></label>
                                                <div class="invalid-feedback">You must agree before submitting.</div>
                                            </div>
                                        </div> -->
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100 button-initial" type="button" onclick="register()">Buat Akun</button>
                                            <button class="btn btn-primary w-100 d-none button-prevent" type="button" disabled>
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                Buat Akun...
                                            </button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Sudah memiliki akun? <a href="{{url('/login')}}">Login</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="credits">
                                Designed by <a href="#">dimaspcm_</a>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{asset('be/assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('be/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('be/assets/vendor/chart.js/chart.umd.js')}}"></script>
    <script src="{{asset('be/assets/vendor/echarts/echarts.min.js')}}"></script>
    <script src="{{asset('be/assets/vendor/quill/quill.min.js')}}"></script>
    <script src="{{asset('be/assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
    <script src="{{asset('be/assets/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('be/assets/vendor/php-email-form/validate.js')}}"></script>
    <script src="{{asset('be/assets/vendor/sweetalert/js/sweetalert2.all.js')}}"></script>

    <!-- Template Main JS File -->
    <script src="{{asset('be/assets/js/main.js')}}"></script>
    <script src="{{asset('extends/register.js')}}"></script>
    <script src="{{asset('extends/configuration.js')}}"></script>
</body>
</html>
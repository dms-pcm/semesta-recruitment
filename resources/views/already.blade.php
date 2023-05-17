<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Sudah Diverifikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <style>
        body{
            background-color: #f6f9ff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row d-flex justify-content-center min-vh-100 pt-5 pb-5">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <p class="d-flex justify-content-center mb-4" style="color:#0d6efd">
                    <img class="me-2" src="{{asset('fe/assets/img/bkk.png')}}" alt="" width="58" height="54">
                    <span class="d-inline-block" style='font-family: "Poppins", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"; font-size: 2.48832rem !important; font-weight: 800 !important;line-height: 1;'>SEMESTA<small class="fs-6 d-flex text-center">recruitment</small></span>
                </p>
                <div class="card">
                <div class="card-body p-4 p-sm-5">
                    <div class="text-center"><img class="d-block mx-auto mb-4" src="{{asset('fe/assets/img/already.png')}}" style="width:100%;" alt="Email" width="100">
                        <h4 class="mb-2" style="font-family: Poppins">Email Kamu Sudah Diverifikasi!!</h4>
                        <p style="font-family: Poppins">Kunjungi website <strong><a href="{{url('/')}}">Semesta Recruitment</a></strong> untuk mendapatkan informasi lainnya mengenai perekrutan tenaga kerja!</p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Notification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
    body {
        font-family: -apple-system, system-ui, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', 'Fira Sans', Ubuntu, Oxygen, 'Oxygen Sans', Cantarell, 'Droid Sans', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Lucida Grande', Helvetica, Arial, sans-serif !important;
        background-color: #f3f2f0;
    }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        let baseUrl = "{{url('/')}}/";
        let urlApi = "{{url('/api')}}/";
    </script>
</head>

<body>
    <!-- <h1>Hello, COK</h1>
    <p>You have a new notification. Please click the link below to view:</p>
    <a href="#">Klik sini cok</a> -->
    <div dir="ltr" class="container" style="margin:0px;width:100%;background-color:#f3f2f0;padding:0px;padding-top:8px;font-family:-apple-system,system-ui,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue','Fira Sans',Ubuntu,Oxygen,'Oxygen Sans',Cantarell,'Droid Sans','Apple Color Emoji','Segoe UI Emoji','Segoe UI Emoji','Segoe UI Symbol','Lucida Grande',Helvetica,Arial,sans-serif">
        <div class="d-flex justify-content-center">
            <!-- <div class="row"> -->
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-4">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/LINE_logo.svg/1024px-LINE_logo.svg.png" class="img-thumbnail" style="" width="70"
                                    alt="Logo Bkk">
                            </div>
                            <div class="col-8">
                                <h1 class="fw-bold">SEMESTA <br><small class="fs-6 d-flex text-center">recruitment</small></h1>
                            </div>
                        </div>
                        <h5 class="card-title">1 Pemberitahuan rekrutmen baru untuk anda</h5>
                        <p class="card-text mt-2" style="font-size:14px;">Tersedia rekrutmen baru yang mungkin cocok untuk kamu.</p>
                        <table role="presentation" valign="top" width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                                <tr>
                                    <td style="width:48px;padding-right:16px" width="48" valign="top">
                                        <a href="#" style="color:#0a66c2;display:inline-block;text-decoration:none"
                                            target="_blank" id="logo">
                                            <img src="{{ $foto }}" alt="" style="outline:none;text-decoration:none;display:inline-block;height:48px;width:48px;border-radius:2px;background-color:#eae6df" class="" width="48" height="48" id="logo">
                                        </a>
                                    </td>
                                    <td valign="top">
                                        <a href="#" style="color:#0a66c2;display:inline-block;text-decoration:none"
                                            target="_blank">
                                            <table role="presentation" valign="top" width="100%" cellspacing="0" cellpadding="0"
                                                border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding-bottom:2px" id="judul">
                                                            <a href="#"
                                                                style="display:inline-block;text-decoration:none;font-size:16px;font-weight:600;line-height:1.25;color:#0a66c2"
                                                                target="_blank">
                                                                {{ $title }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-bottom:4px">
                                                            <p
                                                                style="margin:0;font-weight:400;font-size:14px;line-height:20px;color:#1f1f1f">
                                                                Kuota Pendaftaran · 12 peserta
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table role="presentation" valign="top" width="100%" cellspacing="0"
                                                                cellpadding="0" border="0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="font-size:0" align="left">
                                                                            <div
                                                                                style="display:inline-block;padding-top:4px;padding-right:24px">
                                                                                <table role="presentation" valign="top"
                                                                                    width="100%" cellspacing="0" cellpadding="0"
                                                                                    border="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="width:24px;padding-right:8px"
                                                                                                width="24">
                                                                                                <img src="{{asset('fe/assets/img/radar.png')}}"
                                                                                                    alt="ikon radar"
                                                                                                    style="outline:none;text-decoration:none;display:block;height:24px;width:24px"
                                                                                                    class="" width="24"
                                                                                                    height="24">
                                                                                            </td>
                                                                                            <td>
                                                                                                <p
                                                                                                    style="margin:0;font-weight:400;font-family:-apple-system,system-ui,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue','Fira Sans',Ubuntu,Oxygen,'Oxygen Sans',Cantarell,'Droid Sans','Apple Color Emoji','Segoe UI Emoji','Segoe UI Emoji','Segoe UI Symbol','Lucida Grande',Helvetica,Arial,sans-serif;font-size:12px;line-height:1.25;color:#666666;">
                                                                                                    Aktif merekrut
                                                                                                </p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table role="presentation" valign="top" style="border-collapse:separate;padding-top:24px;text-align:left" width="auto" cellspacing="0"
                            cellpadding="0" border="0">
                            <tbody>
                                <tr>
                                    <td id="btn" style="height:min-content;border-radius:24px;padding-top:12px;padding-bottom:12px;padding-left:24px;padding-right:24px;text-align:center;font-size:16px;font-weight:600;text-decoration-line:none;background-color:#0a66c2;color:#ffffff;border-width:1px;border-style:solid;border-color:#0a66c2;line-height:1.25;min-height:auto!important">
                                        <a href="{{url('/information')}}" aria-hidden="true" style="color:#0a66c2;display:inline-block;text-decoration:none" target="_blank">
                                            <span style="color:#ffffff;text-decoration-line:none"> Lihat semua rekrutmen </span>
                                        </a> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <!-- </div> -->
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!-- <script>
        jQuery(document).ready(function () {
            let htmlLogo = `
            <img src="${baseUrl}storage/{{$foto}}" alt="" style="outline:none;text-decoration:none;display:inline-block;height:48px;width:48px;border-radius:2px;background-color:#eae6df" class="" width="48" height="48">
            `;
            $('#logo').html(htmlLogo);

            let htmlJudul = `
            <a href="${baseUrl}detail-information?={{$idRect}}"
                style="display:inline-block;text-decoration:none;font-size:16px;font-weight:600;line-height:1.25;color:#0a66c2"
                target="_blank">
                {{$title}}
            </a>
            `;
            $('#judul').html(htmlJudul);

            let htmlBtn = `
            <a href="${baseUrl}information" aria-hidden="true" style="color:#0a66c2;display:inline-block;text-decoration:none" target="_blank">
                <span style="color:#ffffff;text-decoration-line:none"> Lihat semua rekrutmen </span>
            </a>
            `;
            $('#btn').html(htmlBtn);
        });
    </script> -->
</body>

</html>
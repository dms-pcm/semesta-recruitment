<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Notification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
    body {
        font-family: -apple-system, system-ui, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', 'Fira Sans', Ubuntu, Oxygen, 'Oxygen Sans', Cantarell, 'Droid Sans', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Lucida Grande', Helvetica, Arial, sans-serif !important;
        background-color: #f3f2f0;
    }
    </style>
</head>

<body>
    <div class="">
        <div id="" class="">
            <div id="" class="">
                <div style="margin:0px;width:100%;background-color:#f3f2f0;padding:0px;padding-top:8px;padding-bottom:8px;font-family:-apple-system,system-ui,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue','Fira Sans',Ubuntu,Oxygen,'Oxygen Sans',Cantarell,'Droid Sans','Apple Color Emoji','Segoe UI Emoji','Segoe UI Emoji','Segoe UI Symbol','Lucida Grande',Helvetica,Arial,sans-serif">
                    <table role="presentation" valign="top" class="" style="margin-left:auto;margin-right:auto;margin-top:0px;margin-bottom:0px;width:512px;max-width:512px;background-color:#ffffff;padding:0px" width="512" cellspacing="0" cellpadding="0" border="0" align="center">
                        <tbody>
                            <tr>
                                <td style="padding:24px;text-align:center">
                                    <table role="presentation" valign="top" style="min-width:100%" width="100%" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td valign="middle" align="left"> 
                                                    <!-- <a href="#" style="color:#0a66c2;display:inline-block;text-decoration:none;width:84px" target="_blank"> -->
                                                        <!-- sementara -->
                                                        <img alt="Logo BKK" src="https://i.postimg.cc/d0kpmyBf/bkk-logo.png" style="outline:none;text-decoration:none;display:block" class="" class="img-thumbnail" width="70">
                                                        <!-- sementara -->
                                                    <!-- </a> -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:24px;padding-right:24px;padding-bottom:24px">
                                    <div>
                                        <table role="presentation" valign="top" style="line-height:1.25" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h1 style="margin:0;font-size:24px;font-weight:400;line-height:1.25">
                                                            Pemberitahuan rekrutmen baru
                                                            <a href="{{ $idRect }}" style="display:inline-block;text-decoration:none;color:#282828" target="_blank">
                                                                <strong style="font-weight:600">{{ $title }}</strong>
                                                            </a>
                                                        </h1>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top:8px">
                                                        <table role="presentation" valign="top" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <h2 style="margin:0;font-size:16px;font-weight:400">
                                                                        Tersedia rekrutmen baru yang mungkin cocok untuk kamu.</h2>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top:24px">
                                                        <table role="presentation" valign="top" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="width:48px;padding-right:16px" width="48" valign="top">
                                                                        <a href="{{ $idRect }}" style="color:#0a66c2;display:inline-block;text-decoration:none" target="_blank">
                                                                            <img src="{{ $foto }}" alt="Flayer" style="outline:none;text-decoration:none;display:inline-block;height:50px;width:50px;border-radius:5px;background-color:#eae6df" class="" width="50" height="50">
                                                                        </a>
                                                                    </td>
                                                                    <td valign="top">
                                                                        <a href="{{ $idRect }}" style="color:#0a66c2;display:inline-block;text-decoration:none" target="_blank">
                                                                            <table role="presentation" valign="top" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style="padding-bottom:2px">
                                                                                            <a href="{{ $idRect }}" style="display:inline-block;text-decoration:none;font-size:16px;font-weight:600;line-height:1.25;color:#0a66c2" target="_blank">
                                                                                                {{ $title }}
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="padding-bottom:4px">
                                                                                            <p style="margin:0;font-weight:400;font-size:14px;line-height:20px;color:#1f1f1f">
                                                                                                Kuota Pendaftaran · <b>{{ $kuota }} peserta</b>
                                                                                            </p>
                                                                                            <p style="margin:0;font-weight:400;font-size:14px;line-height:20px;color:#1f1f1f">
                                                                                                Perusahaan · <b>{{ $company }}</b>
                                                                                            </p>
                                                                                            <p style="margin:0;font-weight:400;font-size:14px;line-height:20px;color:#1f1f1f">
                                                                                                Tanggal Rekrutmen · <b>{{ $date }}</b>
                                                                                            </p>
                                                                                            <p style="margin:0;font-weight:400;font-size:14px;line-height:20px;color:#1f1f1f">
                                                                                                Persyaratan : <br>
                                                                                                @foreach($matchingSyarat as $index => $syarat)
                                                                                                    <b>{{ $loop->iteration }}. {{ $syarat }}</b><br>
                                                                                                @endforeach
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <table role="presentation" valign="top" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td style="font-size:0" align="left">
                                                                                                            <div style="display:inline-block;padding-top:4px;padding-right:24px">
                                                                                                                <table role="presentation" valign="top" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                                                    <tbody>
                                                                                                                        <tr>
                                                                                                                            <td style="width:24px;padding-right:8px" width="24">
                                                                                                                                <img src="https://ci6.googleusercontent.com/proxy/mKuFWACwTEw1B83GJdgkw2gvI52qLKNsKyYqWPeRvWqxzopP-rTLQ1zourXlPG6jNOkoGzyoPzkLkAd2ylWV8gLous_14uLSyAUgMYag_Gy_vg=s0-d-e1-ft#https://static.licdn.com/aero-v1/sc/h/9l6a5sabysjjlpb4xyj1r8g5x" alt="#" style="outline:none;text-decoration:none;display:block;height:24px;width:24px" class="" width="24" height="24">
                                                                                                                            </td>
                                                                                                                            <td>
                                                                                                                                <p style="margin:0;font-weight:400;font-family:-apple-system,system-ui,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue','Fira Sans',Ubuntu,Oxygen,'Oxygen Sans',Cantarell,'Droid Sans','Apple Color Emoji','Segoe UI Emoji','Segoe UI Emoji','Segoe UI Symbol','Lucida Grande',Helvetica,Arial,sans-serif;font-size:12px;line-height:1.25;color:#666666;">
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
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top:24px;text-align:left">
                                                        <table role="presentation" valign="top" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="middle" align="left">
                                                                        <a href="{{url('/information')}}" aria-label="Lihat semua rekrutmen" style="color:#0a66c2;display:inline-block;text-decoration:none" target="_blank">
                                                                            <table role="presentation" valign="top" style="border-collapse:separate" width="auto" cellspacing="0" cellpadding="0" border="0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style="height:min-content;border-radius:24px;padding-top:12px;padding-bottom:12px;padding-left:24px;padding-right:24px;text-align:center;font-size:16px;font-weight:600;text-decoration-line:none;background-color:#0a66c2;color:#ffffff;border-width:1px;border-style:solid;border-color:#0a66c2;line-height:1.25;min-height:auto!important">
                                                                                            <a href="{{url('/information')}}" aria-hidden="true" style="color:#0a66c2;display:inline-block;text-decoration:none" target="_blank">
                                                                                                <span style="color:#ffffff;text-decoration-line:none">
                                                                                                    Lihat semua rekrutmen
                                                                                                </span>
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
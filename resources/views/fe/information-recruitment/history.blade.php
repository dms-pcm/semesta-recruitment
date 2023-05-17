@extends('fe.layout.index')
@section('content')
<!-- ======= Breadcrumbs ======= -->
<div class="breadcrumbs">
    <div class="page-header d-flex align-items-center" style="background-image: url('fe/assets/img/page-header.png');">
        <div class="container position-relative">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6 text-center">
                    <h2 class="title-h2">Riwayat Rekrutmen</h2>
                </div>
            </div>
        </div>
    </div>
    <nav>
        <div class="container">
            <ol>
                <li><a href="{{url('/')}}">Home</a></li>
                <li>Riwayat Rekrutmen</li>
            </ol>
        </div>
    </nav>
</div><!-- End Breadcrumbs -->
<section id="about" class="services">
    <div class="container"><!-- data-aos="zoom-out" -->
        <table id="history" class="table table-hover" style="width:100%">
            <thead style="border: 1px solid black">
                <tr>
                    <th>No</th>
                    <th>Nama Rekrutmen</th>
                    <th>Deskripsi</th>
                    <th>Status Berkas</th>
                    <th>Status Pendaftaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            {{--<tbody>
                <tr>
                    <td>Tiger Nixon</td>
                    <td>System Architect</td>
                    <td>Edinburgh</td>
                    <td><span class="badge bg-warning text-dark">Warning</span></td>
                    <td>
                        <a href="javascript:void(0)" data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li><a class="dropdown-item" href="javascript:void(0)"><i class="bi bi-eye-fill text-info" style="margin-right:5px"></i> Detail</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"><i class="bi bi-pencil-fill text-warning" style="margin-right:5px"></i> Edit</a></li>
                        </ul>
                    </td>
                </tr>
            </tbody>--}}
        </table>
        <div class="row d-flex justify-content-center d-none" id="nothing">
            <img src="{{asset('be/assets/img/nothing.png')}}" style="width:438px;margin-bottom:-20px" alt="Data tidak tersedia">
            <p class="text-center text-muted fs-5 mb-2" style="font-family:arial;">Anda belum melakukan pendaftaran pada rekrutmen...</p>
        </div>

    </div>
</section><!-- End About Us Section -->

<div class="modal fade" id="viewRekt" data-bs-backdrop="static" data-bs-focus="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Riwayat Rekrutmen</h5>
                <button type="button" class="btn-close" onclick="tutup()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="bg-viewRekt">
                    <div class="row" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Nama Rekrutmen</div>
                        <div class="col-lg-9 col-md-8" id="viewNamaRekt">-</div>
                    </div>

                    <div class="row" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Tanggal</div>
                        <div class="col-lg-9 col-md-8" id="viewTanggal">-</div>
                    </div>
    
                    <div class="row" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Pukul</div>
                        <div class="col-lg-9 col-md-8" id="viewPukul">-</div>
                    </div>

                    <div class="row" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Lokasi</div>
                        <div class="col-lg-9 col-md-8" id="viewLokasi">-</div>
                    </div>

                    <div class="row" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Deskripsi</div>
                        <div class="col-lg-9 col-md-8" id="viewDeskripsi">-</div>
                    </div>
    
                    <div class="row" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Status Berkas</div>
                        <div class="col-lg-9 col-md-8" id="viewStatusBerkas">-</div>
                    </div>

                    <div class="row d-none" style="margin-bottom: 18px;" id="alasan">
                        <div class="col-lg-3 col-md-4 label fw-bold">Alasan Berkas Tidak Lengkap</div>
                        <div class="col-lg-9 col-md-8" id="viewAlasan">-</div>
                    </div>

                    <!-- <div class="row d-none" style="margin-bottom: 18px;" id="tb">
                        <div class="col-lg-3 col-md-4 label fw-bold">Tinggi Badan</div>
                        <div class="col-lg-9 col-md-8" id="viewTB">-</div>
                    </div>

                    <div class="row d-none" style="margin-bottom: 18px;" id="bb">
                        <div class="col-lg-3 col-md-4 label fw-bold">Berat Badan</div>
                        <div class="col-lg-9 col-md-8" id="viewBB">-</div>
                    </div> -->

                    <div class="row">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button id="btn-viewBerkas" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Berkas Rekrutmen
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <form>
                                            <div class="row" id="data-diri"></div>
                                            <div class="row" id="berkas">
                                                {{--<div class="col-md-4">
                                                    <div class="card">
                                                        <img src="{{asset('be/assets/img/messages-3.jpg')}}" class="card-img-top" style="height:9rem;object-fit:cover;" alt="...">
                                                        <div class="card-body" style="padding: 0px 10px 10px 10px;">
                                                            <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">Pas Foto</h6>
                                                            <a href="#" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <img src="{{asset('be/assets/img/messages-3.jpg')}}" class="card-img-top" style="height:9rem;object-fit:cover;" alt="...">
                                                        <div class="card-body" style="padding: 0px 10px 10px 10px;">
                                                            <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">Foto Full Body</h6>
                                                            <a href="#" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <img src="{{asset('be/assets/img/messages-3.jpg')}}" class="card-img-top" style="height:9rem;object-fit:cover;" alt="...">
                                                        <div class="card-body" style="padding: 0px 10px 10px 10px;">
                                                            <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">Surat Keterangan Sehat</h6>
                                                            <a href="#" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></a>
                                                        </div>
                                                    </div>
                                                </div>--}}
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLabel">Edit Form Pendaftaran</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <form action="" enctype="multipart/form-data" id="form-daftar">
                @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" placeholder="cth: Cavero Balmond">
                    </div>
                    <div class="mb-3">
                        <label for="noHp" class="form-label">No. Handphone</label>
                        <input type="text" class="form-control" id="noHp" placeholder="cth: 089777888222">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" placeholder="cth: Perancis">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="cth: caverobalmond@gmail.com">
                    </div>
                    <div class="accordion" id="berkasPersyaratan">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="berkas">
                                <button id="btn-edit-coll" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#syarat" aria-expanded="false" aria-controls="syarat">
                                    Berkas Persyaratan
                                </button>
                            </h2>
                            <div id="syarat" class="accordion-collapse collapse" aria-labelledby="berkas" data-bs-parent="#berkasPersyaratan">
                                <div class="accordion-body" id="formberkas">
                                    {{--<div class="mb-3 d-none" id="row-tb">
                                        <label for="tb" class="form-label">Tinggi Badan</label>
                                        <input type="number" class="form-control input-berkas" name="10" id="tb" placeholder="cth: 170">
                                    </div>
                                    <div class="mb-3 d-none" id="row-bb">
                                        <label for="bb" class="form-label">Berat Badan</label>
                                        <input type="number" class="form-control input-berkas" name="11" id="bb" placeholder="cth: 65">
                                    </div>
                                    <div class="mb-3 d-none" id="row-lamaran">
                                        <label for="surat_lamaran" class="form-label">Surat Lamaran</label>
                                        <input type="file" class="form-control input-berkas" name="1" id="surat_lamaran" accept=".pdf">
                                    </div>
                                    <div class="mb-3 d-none" id="row-cv">
                                        <label for="cv" class="form-label">CV</label>
                                        <input type="file" class="form-control input-berkas" name="2" id="cv" accept=".pdf">
                                    </div>
                                    <div class="mb-3 d-none" id="row-ijazah">
                                        <label for="ijazah" class="form-label">Ijazah</label>
                                        <input type="file" class="form-control input-berkas" name="5" id="ijazah" accept=".pdf">
                                    </div>
                                    <div class="mb-3 d-none" id="row-skhun">
                                        <label for="skhun" class="form-label">SKHUN</label>
                                        <input type="file" class="form-control input-berkas" name="6" id="skhun" accept=".pdf">
                                    </div>
                                    <div class="mb-3 d-none" id="row-raport">
                                        <label for="raport" class="form-label">Nilai Raport</label>
                                        <input type="file" class="form-control input-berkas" name="7" id="raport" accept=".pdf">
                                    </div>
                                    <div class="mb-3 d-none" id="row-sehat">
                                        <label for="sk_sehat" class="form-label">Surat Keterangan Sehat</label>
                                        <input type="file" class="form-control input-berkas" name="8" id="sk_sehat" accept=".pdf">
                                    </div>
                                    <div class="mb-3 d-none" id="row-warna">
                                        <label for="buta_warna" class="form-label">Tidak Buta Warna</label>
                                        <input type="file" class="form-control input-berkas" name="9" id="buta_warna" accept=".pdf">
                                    </div>
                                    <div class="mb-3 d-none" id="row-hidup">
                                        <label for="essay_hidup" class="form-label">Essay Tentang Pengalaman Hidup</label>
                                        <input type="file" class="form-control input-berkas" name="12" id="essay_hidup" accept=".pdf">
                                    </div>
                                    <div class="mb-3 d-none" id="row-depan">
                                        <label for="essay_depan" class="form-label">Essay Tentang Target Masa Depan</label>
                                        <input type="file" class="form-control input-berkas" name="13" id="essay_depan" accept=".pdf">
                                    </div>
                                    <!-- <div class="mb-3 d-none" id="row-foto"> -->
                                        <div class="row mb-3 d-none" id="row-foto">
                                            <div class="col-md-6">
                                                <label for="" class="form-label">Pas Foto</label>
                                                <div class="input-group">
                                                    <label class="btn btn-primary" style="border-radius: 5px;" for="pas_foto"><i class="bi bi-pencil-fill me-1"></i> Pilih File</label>
                                                    <input type="file" class="form-control d-none input-berkas" name="3" id="pas_foto" accept="image/png, image/jpg, image/jpeg">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="" class="form-label">Preview</label>
                                                <img class="img-upload-rekrutmen" id="blah_pas" src="{{asset('fe/assets/img/user.png')}}" alt="">
                                            </div>
                                        </div>
                                    <!-- </div> -->
                                    <!-- <div class="mb-3 d-none" id="row-full"> -->
                                        <div class="row mb-3 d-none" id="row-full">
                                            <div class="col-md-6">
                                                <label for="" class="form-label">Foto Full Body</label>
                                                <div class="input-group">
                                                    <label class="btn btn-primary" style="border-radius: 5px;" for="full_body"><i class="bi bi-pencil-fill me-1"></i> Pilih File</label>
                                                    <input type="file" class="form-control d-none input-berkas" name="4" id="full_body" accept="image/png, image/jpg, image/jpeg">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="" class="form-label">Preview</label>
                                                <img class="img-upload-rekrutmen" id="blah_full" src="{{asset('fe/assets/img/user.png')}}" alt="">
                                            </div>
                                        </div>--}}
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="tutupEdit()">Tutup</button>
                <button type="button" class="btn btn-primary" id="ubah">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('extends/fe/history.js')}}"></script>
<script>
    jQuery(document).ready(function () {
        $('#hero').addClass('d-none');
    });
</script>
@endsection
@extends('fe.layout.index')
@section('content')
<!-- ======= Breadcrumbs ======= -->
<div class="breadcrumbs">
    <div class="page-header d-flex align-items-center" style="background-image: url('fe/assets/img/page-header.png');">
        <div class="container position-relative">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6 text-center">
                    <h2 class="title-h2">Detail Rekrutmen</h2>
                </div>
            </div>
        </div>
    </div>
    <nav>
        <div class="container">
            <ol>
                <li><a href="{{url('/')}}">Home</a></li>
                <li>Detail Rekrutmen</li>
            </ol>
        </div>
    </nav>
</div><!-- End Breadcrumbs -->

<!-- ======= Service Details Section ======= -->
<section id="service-details" class="service-details">
    <div class="container"> <!-- data-aos="zoom-out" -->
        <div class="alert alert-warning alert-dismissible fade show d-none" role="alert" id="attention">
            <strong>Pemberitahuan!</strong> Anda sudah melakukan pendaftaran pada rekrutmen ini. 
            Anda bisa melihat riwayat rekrutmen <a href="{{url('history')}}">disini</a> atau mencari rekrutmen lainnya <a href="{{url('/information')}}">disini</a> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="row gy-4">

            <div class="col-lg-4">
                <div class="services-list">
                    <a href="javascript:void(0)" class="fw-bold">Lokasi <br><br> <small style="font-weight:400;" id="lokasi"></small></a>
                    <a href="javascript:void(0)" class="fw-bold">Tanggal <br><br> <small style="font-weight:400;" id="tgl"></small></a>
                    <a href="javascript:void(0)" class="fw-bold">Pukul <br><br> <small style="font-weight:400;" id="pukul"></small></a>
                    <a href="javascript:void(0)" class="fw-bold">Kuota Pendaftaran <br><br> <small style="font-weight:400;" id="quantity"></small></a>
                </div>
            </div>

            <div class="col-lg-8">
                <div id="img-rekt">

                </div>
                <!-- <img src="" id="img-rekt" style="height:541px;object-fit:cover;" alt="Flayer" class="img-fluid services-img"> -->
                <h3 id="judul"></h3>
                <p id="desk"></p>
                <p class="fw-bold" style="margin-bottom:0px;font-size:20px;">Kualifikasi</p>
                <ul id="list-syarat">
                    {{--<li><i class="bi bi-check-circle"></i> <span>Surat Lamaran</span></li>
                    <li><i class="bi bi-check-circle"></i> <span>CV</span></li>
                    <li><i class="bi bi-check-circle"></i> <span>Pas Foto</span></li>--}}
                </ul>

                <div>
                    <button class="btn btn-primary text-white float-end" onclick="showModal()" id="btn-modal"><i class="bi bi-person-plus-fill me-1"></i> Daftar</button>
                </div>
            </div>

        </div>

    </div>
</section><!-- End Service Details Section -->

<!-- Modal -->
<div class="modal fade" id="apply" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="applyLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applyLabel">Form Pendaftaran</h5>
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
                        <input type="text" class="form-control" id="noHp" placeholder="cth: 089777888222" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
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
                                <button class="accordion-button collapsed" id="btn-according-syarat" type="button" data-bs-toggle="collapse" data-bs-target="#syarat" aria-expanded="false" aria-controls="syarat">
                                    Berkas Persyaratan
                                </button>
                            </h2>
                            <div id="syarat" class="accordion-collapse collapse" aria-labelledby="berkas" data-bs-parent="#berkasPersyaratan">
                                <div class="accordion-body" id="formberkas">
                                    {{--<div class="mb-3 d-none" id="row-tb">
                                        <label for="tb" class="form-label">Tinggi Badan</label>
                                        <input type="text" class="form-control input-berkas" name="10" id="tb" placeholder="cth: 170" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    </div>
                                    <div class="mb-3 d-none" id="row-bb">
                                        <label for="bb" class="form-label">Berat Badan</label>
                                        <input type="text" class="form-control input-berkas" name="11" id="bb" placeholder="cth: 65" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
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
                                                    <input type="file" class="form-control d-none input-berkas" name="3" id="" accept="image/png, image/jpg, image/jpeg">
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
                <button type="button" class="btn btn-secondary" onclick="tutup()">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="daftar()">Daftar Sekarang</button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('extends/fe/detail-information.js')}}"></script>
<script>
    jQuery(document).ready(function () {
        $('#hero').addClass('d-none');
    });
</script>
@endsection
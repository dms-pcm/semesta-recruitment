@extends('be.layout.index')
@section('content')

<div class="pagetitle">
    <h1>Data Peserta</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/be-admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Data Peserta</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
            <div class="row">

                <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <div class="row title">
                                <div class="col-md-5">
                                    <h5 class="card-title">Daftar Peserta Rekrutmen</h5>
                                </div>
                                <div class="col-md-7">
                                    <div class="export">
                                        <!-- <button type="button" class="btn btn-warning " ><i class="bi bi-file-earmark-arrow-up-fill me-1"></i> Export</button> -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning dropdown-toggle d-none" id="export" data-bs-toggle="dropdown" aria-expanded="false">
                                                Export
                                            </button>
                                            <ul class="dropdown-menu">
                                                <!-- <li><a class="dropdown-item" href="javascript:void(0)" id="daftar-hadir">Daftar Hadir</a></li> -->
                                                <li><a class="dropdown-item" href="javascript:void(0)" id="daftar-hadir-pdf">Daftar Hadir</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)" id="data-peserta">Data Peserta</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <select class="selectpicker col-12" name="inputFilter" id="inputFilter" placeholder="Pilih rekrutmen" data-live-search="true">
                                        {{--<option value="0">Zero</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>--}}
                                    </select>
                                </div>
                                <div class="col-md-2 tampilkan">
                                    <button type="button" class="btn btn-primary mb-3" onclick="filter()"><i class="bi bi-view-list me-1"></i> Tampilkan</button>
                                </div>
                                <!-- <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-secondary mb-3 d-none" id="btn-hadir">Buat Daftar Hadir</button>
                                </div> -->
                            </div>

                            <table class="table d-none w-100" id="tbl-peserta">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Peserta</th>
                                        <th scope="col">No. Handphone</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Status Berkas</th>
                                        <th scope="col">Status Peserta</th>
                                        <th scope="col">Aksi</th>
                                        <!-- <th scope="col">Status</th> -->
                                    </tr>
                                </thead>
                                {{--<tbody>
                                    <tr>
                                        <th scope="row"><a href="#">2457</a></th>
                                        <td>Brandon Jacob</td>
                                        <td><a href="#" class="text-primary">At praesentium minu</a></td>
                                        <!-- <td>$64</td> -->
                                        <td>
                                            <button type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                        </td>
                                    </tr>
                                </tbody>--}}
                            </table>

                            <div class="row d-flex justify-content-center" id="selectRekrutmen">
                                <img src="{{asset('be/assets/img/option.png')}}" style="width:438px;margin-bottom:-20px" alt="Pilih rekrutmen">
                                <p class="text-center text-muted fs-5 mb-2" style="font-family:arial;">Silahkan pilih rekrutmen terlebih dahulu...</p>
                            </div>

                            <div class="row d-flex justify-content-center d-none" id="nothing">
                                <img src="{{asset('be/assets/img/nothing.png')}}" style="width:438px;margin-bottom:-20px" alt="Data tidak tersedia">
                                <p class="text-center text-muted fs-5 mb-2" style="font-family:arial;">Ups!... tidak ada hasil yang ditemukan</p>
                            </div>

                        </div>

                    </div>
                </div><!-- End Recent Sales -->

            </div>
        </div><!-- End Left side columns -->

    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="viewParticipant" data-bs-backdrop="static" data-bs-focus="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Peserta Rekrutmen</h5>
                <button type="button" class="btn-close" onclick="tutup()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="bg-viewJadwal">
                    <div class="row" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Nama</div>
                        <div class="col-lg-9 col-md-8" id="viewNama">-</div>
                    </div>
    
                    <div class="row" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">No.Handphone</div>
                        <div class="col-lg-9 col-md-8" id="viewPhone">-</div>
                    </div>

                    <div class="row" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Alamat</div>
                        <div class="col-lg-9 col-md-8" id="viewAlamat">-</div>
                    </div>
    
                    <div class="row" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Email</div>
                        <div class="col-lg-9 col-md-8" id="viewEmail">-</div>
                    </div>
    
                    <div class="row" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Status Berkas</div>
                        <div class="col-lg-9 col-md-8" id="viewStatusBerkas">-</div>
                    </div>

                    <div class="row" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Status Peserta</div>
                        <div class="col-lg-9 col-md-8" id="viewStatusPeserta">-</div>
                    </div>

                    <div class="row d-none" style="margin-bottom: 18px;" id="alasan">
                        <div class="col-lg-3 col-md-4 label fw-bold">Alasan Berkas Tidak Lengkap</div>
                        <div class="col-lg-9 col-md-8" id="viewAlasan">-</div>
                    </div>

                    <div class="row d-none" style="margin-bottom: 18px;" id="tb">
                        <div class="col-lg-3 col-md-4 label fw-bold">Tinggi Badan</div>
                        <div class="col-lg-9 col-md-8" id="viewTB">-</div>
                    </div>

                    <div class="row d-none" style="margin-bottom: 18px;" id="bb">
                        <div class="col-lg-3 col-md-4 label fw-bold">Berat Badan</div>
                        <div class="col-lg-9 col-md-8" id="viewBB">-</div>
                    </div>

                    <div class="row">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button id="btn-viewBerkas" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Berkas Peserta Rekrutmen
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
            <div class="modal-footer" id="footer-btn">
                <button id="btn-complete" type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Berkas Belum Lengkap" onclick="incomplete_file()"><i class="bi bi-folder-x"></i></button>
                <button id="btn-incomplete" type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Berkas Sudah Lengkap" onclick="complete_file()"><i class="bi bi-folder-check"></i></button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('extends/participants.js')}}"></script>
<!-- <script>
    jQuery(document).ready(function () {
        let html = ``;
        for (let i = 0; i < 5; i++) {
            html+=`
            <div class="col-md-4">
                <div class="card">
                    <img src="{{asset('be/assets/img/messages-3.jpg')}}" class="card-img-top" style="height:9rem;object-fit:cover;" alt="...">
                    <div class="card-body" style="padding: 0px 10px 10px 10px;">
                        <h6 class="card-title" style="font-size:0.9rem;margin-bottom:0px;">Pas Foto</h6>
                        <a href="#" class="btn btn-primary" style="margin-top:-8px;"><i class="bi bi-download"></i></a>
                    </div>
                </div>
            </div>
            `;
        }
        $('#berkas').html(html);
    });
</script> -->
@endsection
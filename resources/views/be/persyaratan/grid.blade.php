@extends('be.layout.index')
@section('content')

<div class="pagetitle">
    <h1>Persyaratan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/be-admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Persyaratan</li>
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
                            <h5 class="card-title">Daftar Persyaratan</h5>
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#buatSyarat">Tambah Persyaratan</button>

                            <table class="table w-100" id="tbl-persyaratan">
                                <thead>
                                    <tr>
                                    <!-- width="400px" -->
                                        <th scope="col">No</th>
                                        <th scope="col">Persyaratan</th>
                                        <th scope="col">Tipe</th>
                                        <th scope="col">Format</th>
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
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-outline-primary dropdown-toggle" id="aksi" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></button>
                                                <ul class="dropdown-menu" aria-labelledby="aksi">
                                                    <li><a class="dropdown-item" href="javascript:void(0)"><i class="bi bi-eye-fill text-info"></i> Detail</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)"><i class="bi bi-pencil-fill text-warning"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)"><i class="bi bi-trash-fill text-danger"></i> Hapus</a></li>
                                                </ul>
                                            </div>
                                            <div class="filter">
                                                <a href="javascript:void(0)" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                    <li class="dropdown-header text-start">
                                                    <h6>Aksi</h6>
                                                    </li>

                                                    <li><a class="dropdown-item" href="javascript:void(0)"><i class="bi bi-eye-fill text-info"></i> Detail</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)"><i class="bi bi-pencil-fill text-warning"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)">This Year</a></li>
                                                </ul>
                                            </div>
                                            <!-- <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewJadwal"><i class="bi bi-eye-fill"></i></button>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editJadwal"><i class="bi bi-pencil-fill"></i></button>
                                            <button type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button> -->
                                        </td>
                                    </tr>
                                </tbody>--}}
                            </table>

                        </div>

                    </div>
                </div><!-- End Recent Sales -->

            </div>
        </div><!-- End Left side columns -->

    </div>
</section>

<div class="modal fade" id="buatSyarat" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Persyaratan Rekrutmen</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <!-- Multi Columns Form -->
                <form class="row g-3" enctype="multipart/form-data">
                @csrf
                    <div class="col-md-12">
                        <label for="inputPersyaratan" class="form-label">Persyaratan</label>
                        <input type="text" class="form-control" id="inputPersyaratan" placeholder="Masukan persyaratan rekrutmen">
                    </div>
                    <div class="col-md-6">
                        <label for="inputTipe" class="form-label">Tipe Inputan</label>
                        <select class="selectpicker col-12" name="inputValueTipe" id="inputTipe" placeholder="Pilih tipe persyaratan">
                            <option value="file">File</option>
                            <option value="text">Text</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-none" id="row-format">
                        <label for="inputFormat" class="form-label">Format File</label>
                        <select class="selectpicker col-12" name="inputValueFile" id="inputFormat" placeholder="Pilih format file">
                            <option value="pdf">.PDF</option>
                            <option value="png,jpeg,jpg">.PNG, .JPEG, .JPG</option>
                        </select>
                    </div>
                </form><!-- End Multi Columns Form -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="tutup()">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="tambahSyarat()">Tambah</button>
            </div>
        </div>
    </div>
</div><!-- End Buat Jadwal Modal-->

<div class="modal fade" id="editSyarat" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Persyaratan Rekrutmen</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <!-- Multi Columns Form -->
                <form class="row g-3" enctype="multipart/form-data" id="formPersyaratan">
                @csrf
                    <div class="col-md-12">
                        <label for="editPersyaratan" class="form-label">Persyaratan</label>
                        <input type="text" class="form-control" id="editPersyaratan" placeholder="Masukan persyaratan rekrutmen">
                    </div>
                    <div class="col-md-6">
                        <label for="editTipe" class="form-label">Tipe Inputan</label>
                        <select class="selectpicker col-12" name="editValueTipe" id="editTipe" placeholder="Pilih tipe persyaratan">
                            <option value="file">File</option>
                            <option value="text">Text</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-none" id="row-Editformat">
                        <label for="editFormat" class="form-label">Format File</label>
                        <select class="selectpicker col-12" name="editValueFile" id="editFormat" placeholder="Pilih format file">
                            <option value="pdf">.PDF</option>
                            <option value="png,jpeg,jpg">.PNG, .JPEG, .JPG</option>
                        </select>
                    </div>
                </form><!-- End Multi Columns Form -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-ubah">Ubah</button>
            </div>
        </div>
    </div>
</div><!-- End Buat Jadwal Modal-->
<script src="{{asset('extends/persyaratan.js')}}"></script>
@endsection
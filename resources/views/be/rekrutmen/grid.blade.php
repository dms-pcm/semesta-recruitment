@extends('be.layout.index')
@section('content')

<div class="pagetitle">
    <h1>Rekrutmen</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/be-admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Rekrutmen</li>
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

                        <!-- <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div> -->

                        <div class="card-body">
                            <h5 class="card-title">Daftar Rekrutmen</h5>
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#buatJadwal"><i class="bi bi-plus-circle me-1"></i> Buat Jadwal</button>

                            <table class="table w-100" id="tbl-rekrutmen">
                                <thead>
                                    <tr>
                                    <!-- width="400px" -->
                                        <th scope="col">No</th>
                                        <th scope="col">Judul</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Pukul</th>
                                        <th scope="col">Kuota Pendaftaran</th>
                                        <th scope="col">Status</th>
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

<div class="modal fade" id="buatJadwal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Jadwal Rekrutmen</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <!-- Multi Columns Form -->
                <form class="row g-3" enctype="multipart/form-data" id="recruitment">
                @csrf
                    <div class="col-md-12">
                        <label for="inputJudul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="inputJudul" placeholder="Masukan judul rekrutmen">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPukul" class="form-label">Waktu</label>
                        <input type="text" class="form-control" id="inputPukul" placeholder="Masukan waktu rekrutmen">
                    </div>
                    <div class="col-md-6">
                        <label for="inputLokasi" class="form-label">Lokasi</label>
                        <textarea type="text" class="form-control" id="inputLokasi" style="height:36px;overflow:hidden;" onkeyup="textAreaAdjust(this)" placeholder="Masukan lokasi rekrutmen"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Upload Gambar</label><br>
                        <label class="custom-file-upload">
                            <label for="inputGambar" class="btn btn-primary mb-3"><i class="bi bi-pencil-fill me-1"></i> Pilih File</label>
                            <input type="file" id="inputGambar" class="d-none" accept=".png, .jpg, .jpeg"/>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Preview</label><br>
                        <img class="img-upload-rekrutmen" id="blah" src="{{asset('be/assets/img/no_image.png')}}" alt="">
                    </div>
                    <div class="col-12">
                        <label for="inputPersyaratan" class="form-label">Persyaratan</label>
                        <select class="selectpicker col-12" name="inputValue" id="inputPersyaratan" multiple placeholder="Pilih persyaratan rekrutmen" data-actions-box="true" data-live-search="true">
                            {{--<option value="Surat Lamaran">Surat Lamaran</option>
                            <option value="CV">CV</option>
                            <option value="Pas Foto">Pas Foto</option>
                            <option value="Foto Full Body">Foto Full Body</option>
                            <option value="Ijazah">Ijazah</option>
                            <option value="SKHUN">SKHUN</option>
                            <option value="Nilai Raport">Nilai Raport</option>
                            <option value="Surat Keterangan Sehat">Surat Keterangan Sehat</option>
                            <option value="Tidak Buta Warna">Tidak Buta Warna</option>
                            <option value="Tinggi Badan">Tinggi Badan</option>
                            <option value="Berat Badan">Berat Badan</option>
                            <option value="Essay Tentang Pengalaman Hidup">Essay Tentang Pengalaman Hidup</option>
                            <option value="Essay Tentang Target Masa Depan">Essay Tentang Target Masa Depan</option>--}}
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="inputCompany" class="form-label">Perusahaan</label>
                        <input type="text" class="form-control" id="inputCompany" placeholder="Masukan nama perusahaan">
                    </div>
                    <div class="col-12">
                        <label for="quantity" class="form-label">Kuota Pendaftaran</label><br>
                        <div class="number-input">
                            <button type="button" id="sub2" class="sub"><i class="bi bi-chevron-left"></i></button>
                            <input type="number" id="quantity-peserta" value="1" min="1" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;"/>
                            <button type="button" id="add2" class="add"><i class="bi bi-chevron-right"></i></button>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="inputDeskripsi" class="form-label">Deskripsi</label>
                        <textarea type="text" class="form-control" id="inputDeskripsi" style="height:130px" placeholder="Masukan deskripsi rekrutmen"></textarea>
                    </div>
                </form><!-- End Multi Columns Form -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="tutup()">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="addRecruitment()">Buat</button>
            </div>
        </div>
    </div>
</div><!-- End Buat Jadwal Modal-->

<div class="modal fade" id="viewJadwal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Jadwal Rekrutmen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="bg-viewJadwal">
                    <div class="row detail-rekrutmen" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Judul</div>
                        <div class="col-lg-9 col-md-8" id="viewJudul">-</div>
                    </div>
    
                    <div class="row detail-rekrutmen" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Tanggal</div>
                        <div class="col-lg-9 col-md-8" id="viewTanggal">-</div>
                    </div>

                    <div class="row detail-rekrutmen" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Pukul</div>
                        <div class="col-lg-9 col-md-8" id="viewPukul">-</div>
                    </div>
    
                    <div class="row detail-rekrutmen" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Lokasi</div>
                        <div class="col-lg-9 col-md-8" id="viewLokasi">-</div>
                    </div>
    
                    <div class="row detail-rekrutmen" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Persyaratan</div>
                        <div class="col-lg-9 col-md-8" id="viewPersyaratan">-</div>
                    </div>
    
                    <div class="row detail-rekrutmen" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Perusahaan</div>
                        <div class="col-lg-9 col-md-8" id="viewCompany">-</div>
                    </div>

                    <div class="row detail-rekrutmen" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Kuota Pendaftaran</div>
                        <div class="col-lg-9 col-md-8" id="viewQuantity">-</div>
                    </div>

                    <div class="row detail-rekrutmen" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Deskripsi</div>
                        <div class="col-lg-9 col-md-8" id="viewDeskripsi">-</div>
                    </div>
    
                    <div class="row" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Foto</div>
                        <div class="col-lg-9 col-md-8" id="viewFoto">
                            {{--<img class="img-view-rekrutmen" src="{{asset('be/assets/img/news-5.jpg')}}" alt="">--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Detail Jadwal Modal-->

<div class="modal fade" id="editJadwal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Jadwal Rekrutmen</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <!-- Multi Columns Form -->
                <form class="row g-3" enctype="multipart/form-data">
                @csrf
                    <div class="col-md-12">
                        <label for="editJudul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="editJudul" placeholder="Masukan judul rekrutmen">
                    </div>
                    <div class="col-md-6">
                        <label for="editPukul" class="form-label">Pukul</label>
                        <input type="text" class="form-control" id="editPukul" placeholder="Masukan waktu rekrutmen">
                    </div>
                    <div class="col-md-6">
                        <label for="editLokasi" class="form-label">Lokasi</label>
                        <textarea type="text" class="form-control" id="editLokasi" style="overflow:hidden;" onkeyup="textAreaAdjust(this)" placeholder="Masukan lokasi rekrutmen"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Upload Gambar</label><br>
                        <label class="custom-file-upload">
                            <label for="editGambar" class="btn btn-primary mb-3"><i class="bi bi-pencil-fill me-1"></i> Pilih File</label>
                            <input type="file" id="editGambar" class="d-none" accept=".png, .jpg, .jpeg"/>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Preview</label><br>
                        <img class="img-upload-rekrutmen" id="preview_edit" src="{{asset('be/assets/img/no_image.png')}}" alt="">
                    </div>
                    <div class="col-12">
                        <label for="editPersyaratan" class="form-label">Persyaratan</label>
                        <select class="selectpicker col-12" name="valueSyarat" id="editPersyaratan" multiple placeholder="Pilih persyaratan rekrutmen" data-actions-box="true" data-live-search="true">
                            {{--<option value="Surat Lamaran">Surat Lamaran</option>
                            <option value="CV">CV</option>
                            <option value="Pas Foto">Pas Foto</option>
                            <option value="Foto Full Body">Foto Full Body</option>
                            <option value="Ijazah">Ijazah</option>
                            <option value="SKHUN">SKHUN</option>
                            <option value="Nilai Raport">Nilai Raport</option>
                            <option value="Surat Keterangan Sehat">Surat Keterangan Sehat</option>
                            <option value="Tidak Buta Warna">Tidak Buta Warna</option>
                            <option value="Tinggi Badan">Tinggi Badan</option>
                            <option value="Berat Badan">Berat Badan</option>
                            <option value="Essay Tentang Pengalaman Hidup">Essay Tentang Pengalaman Hidup</option>
                            <option value="Essay Tentang Target Masa Depan">Essay Tentang Target Masa Depan</option>--}}
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="editCompany" class="form-label">Perusahaan</label>
                        <input type="text" class="form-control" id="editCompany" placeholder="Masukan nama perusahaan">
                    </div>
                    <div class="col-12">
                        <label for="quantity" class="form-label">Kuota Pendaftaran</label><br>
                        <div class="number-input">
                            <button type="button" id="sub2" class="sub"><i class="bi bi-chevron-left"></i></button>
                            <input type="number" id="edit-quantity-peserta" value="1" min="1" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;"/>
                            <button type="button" id="add2" class="add"><i class="bi bi-chevron-right"></i></button>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="editDeskripsi" class="form-label">Deskripsi</label>
                        <textarea type="text" class="form-control" id="editDeskripsi" style="height:130px" placeholder="Masukan deskripsi rekrutmen"></textarea>
                    </div>
                </form><!-- End Multi Columns Form -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-ubah">Ubah</button>
            </div>
        </div>
    </div>
</div><!-- End Edit Jadwal Modal-->
<script src="{{asset('extends/rekrutmen.js')}}"></script>
@endsection
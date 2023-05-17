@extends('fe.layout.index')
@section('content')
<!-- ======= Breadcrumbs ======= -->
<div class="breadcrumbs">
    <div class="page-header d-flex align-items-center" style="background-image: url('fe/assets/img/page-header.png');">
        <div class="container position-relative">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6 text-center">
                    <h2 class="title-h2">Profile Anda</h2>
                </div>
            </div>
        </div>
    </div>
    <nav>
        <div class="container">
            <ol>
                <li><a href="{{url('/')}}">Home</a></li>
                <li>Profile</li>
            </ol>
        </div>
    </nav>
</div><!-- End Breadcrumbs -->

<section id="about" class="section profile">
    <div class="container" data-aos="fade-up">
        
        <div class="row gy-4">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center" style="padding: 0 20px 20px 20px;">
                        <img src="{{asset('be/assets/img/default-profile.jpg')}}" style="width: 120px;height: 120px;object-fit: cover;" alt="Profile" class="rounded-circle" id="blah" />
                        <h2 class="text-capitalize" id="name"></h2>
                        <h3 class="fw-light" id="sahaan"></h3>
                        <div class="social-links mt-2">
                            <a href="javascript:void(0)" id="tw" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="javascript:void(0)" id="fb" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="javascript:void(0)" id="ig" class="instagram"><i class="bi bi-instagram"></i></a>
                            <!-- <a href="javascript:void(0)" class="linkedin"><i class="bi bi-linkedin"></i></a> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3" style="padding: 0 20px 20px 20px;">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">
                                    Overview
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">
                                    Edit Profile
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">
                                    Ubah Password
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-cv">
                                    Curiculum Vitae
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Details Profile</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Nama Lengkap</div>
                                    <div class="col-lg-9 col-md-8" id="fullName">-</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Negara</div>
                                    <div class="col-lg-9 col-md-8" id="Country">-</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Alamat</div>
                                    <div class="col-lg-9 col-md-8" id="Address">-</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">No. Handphone</div>
                                    <div class="col-lg-9 col-md-8" id="Phone">-</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8" id="Email">-</div>
                                </div>
                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <!-- Profile Edit Form -->
                                <form enctype="multipart/form-data">
                                @csrf
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto Profile</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img src="{{asset('be/assets/img/default-profile.jpg')}}" alt="Profile" id="prev" />
                                            <div class="pt-2">
                                                <label class="btn btn-primary btn-sm" title="Upload foto baru" for="foto_profile"><i class="bi bi-upload text-white"></i></label>
                                                <input type="file" class="form-control d-none" id="foto_profile" accept="image/png, image/jpg, image/jpeg">
                                                <a href="javascript:void(0)" onclick="hapus()" class="btn btn-danger btn-sm" title="Hapus foto profile"><i
                                                        class="bi bi-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="fullName" type="text" class="form-control" id="input-fullName"
                                                placeholder="cth: Kevin Anderson" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Country" class="col-md-4 col-lg-3 col-form-label">Negara</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="country" type="text" class="form-control" id="input-Country"
                                                placeholder="cth: USA" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Address" class="col-md-4 col-lg-3 col-form-label">Alamat Lengkap</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="address" type="text" class="form-control" id="input-Address"
                                                placeholder="cth: A108 Adam Street, New York, NY 535022" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">No. Handphone</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="phone" type="text" class="form-control" id="input-Phone"
                                                placeholder="cth: (436) 486-3538 x29071" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control" id="input-Email"
                                                placeholder="cth: k.anderson@example.com" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter
                                            Profile</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="twitter" type="text" class="form-control" id="input-Twitter"
                                                placeholder="cth: https://twitter.com/#" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook
                                            Profile</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="facebook" type="text" class="form-control" id="input-Facebook"
                                                placeholder="cth: https://facebook.com/#" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram
                                            Profile</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="instagram" type="text" class="form-control" id="input-Instagram"
                                                placeholder="cth: https://instagram.com/#" />
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="button" onclick="ubah()" class="btn btn-primary">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                                <!-- End Profile Edit Form -->
                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <div class="row mb-3">
                                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Password Lama</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password" type="password" class="form-control"
                                            id="currentPassword" placeholder="Masukan password anda"/>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Password Baru</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="newpassword" type="password" class="form-control"
                                            id="newPassword" placeholder="Masukan password baru"/>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Masukan Kembali Password Baru</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="renewpassword" type="password" class="form-control"
                                            id="renewPassword" placeholder="Masukan konfirmasi password"/>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="button" onclick="ubahPassword()" class="btn btn-primary">
                                        Ubah Password
                                    </button>
                                </div>
                                <!-- End Change Password Form -->
                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-cv">
                                <!-- Upload CV Form -->
                                <div class="row mb-3 d-none" id="row-exits-cv">
                                    <div class="col-md-8 col-lg-9">
                                        <i class="bi bi-file-earmark-pdf-fill text-primary fs-2"><span class="fs-6" style="font-style:normal;" id="name-file"></span></i>
                                    </div>
                                </div>
                                <form enctype="multipart/form-data" id="form-cv">
                                @csrf
                                    <div class="row mb-3">
                                        <label for="cv" class="col-md-4 col-lg-3 col-form-label">Upload CV</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="file" class="form-control" id="cv" accept=".pdf"/>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="button" onclick="uploadCV()" class="btn btn-primary">
                                            Upload
                                        </button>
                                    </div>
                                </form>
                                <!-- End Change Password Form -->
                            </div>
                        </div>
                        <!-- End Bordered Tabs -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</section><!-- End About Us Section -->

<script src="{{asset('extends/fe/profile.js')}}"></script>
<script>
    jQuery(document).ready(function () {
        $('#hero').addClass('d-none');
    });
</script>
@endsection
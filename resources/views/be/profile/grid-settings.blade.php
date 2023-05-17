@extends('be.layout.index')
@section('content')

<div class="pagetitle">
    <h1>Setting</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/be-admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item">User</li>
            <li class="breadcrumb-item active">Setting</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section profile">
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <img src="{{asset('be/assets/img/default-profile.jpg')}}" alt="Profile" class="rounded-circle" id="blah"/>
                    <h2 class="text-capitalize" id="name">-</h2>
                    <!-- <h3 class="text-capitalize" id="sahaan">-</h3> -->
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
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">
                                Edit Profile
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">
                                Ubah Password
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
                            <!-- Profile Edit Form -->
                            <form enctype="multipart/form-data" id="profile">
                            @csrf
                                <div class="row mb-3">
                                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto Profile</label>
                                    <div class="col-md-8 col-lg-9">
                                        <img src="{{asset('be/assets/img/default-profile.jpg')}}" alt="Profile" id="prev" />
                                        <div class="pt-2">
                                            <label class="btn btn-primary btn-sm" title="Upload foto baru" for="foto_profile"><i class="bi bi-upload text-white"></i></label>
                                            <input type="file" class="form-control d-none" id="foto_profile" accept="image/png, image/jpg, image/jpeg">
                                            <!-- <a href="#" class="btn btn-primary btn-sm"
                                                title="Upload foto baru"><i class="bi bi-upload"></i></a> -->
                                            <a href="javascript:void(0)" onclick="hapus()" class="btn btn-danger btn-sm" title="Hapus foto profile"><i
                                                    class="bi bi-trash"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="fullName" type="text" class="form-control" id="fullName"
                                            placeholder="cth: Kevin Anderson" />
                                    </div>
                                </div>

                                <!-- <div class="row mb-3">
                                    <label for="company" class="col-md-4 col-lg-3 col-form-label">Perusahaan</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="company" type="text" class="form-control" id="company"
                                            placeholder="cth: Lueilwitz, Wisoky and Leuschke" />
                                    </div>
                                </div> -->

                                <div class="row mb-3">
                                    <label for="Country" class="col-md-4 col-lg-3 col-form-label">Negara</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="country" type="text" class="form-control" id="Country"
                                            placeholder="cth: USA" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Address" class="col-md-4 col-lg-3 col-form-label">Alamat Lengkap</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="address" type="text" class="form-control" id="Address"
                                            placeholder="cth: A108 Adam Street, New York, NY 535022" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Phone" class="col-md-4 col-lg-3 col-form-label">No. Handphone</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="phone" type="text" class="form-control" id="Phone"
                                            placeholder="cth: (436) 486-3538 x29071" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="email" class="form-control" id="Email"
                                            placeholder="cth: k.anderson@example.com" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter
                                        Profile</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="twitter" type="text" class="form-control" id="Twitter"
                                            placeholder="cth: https://twitter.com/#" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook
                                        Profile</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="facebook" type="text" class="form-control" id="Facebook"
                                            placeholder="cth: https://facebook.com/#" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram
                                        Profile</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="instagram" type="text" class="form-control" id="Instagram"
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

                        <div class="tab-pane fade pt-3" id="profile-change-password">
                            <!-- Change Password Form -->
                            <!-- <form enctype="multipart/form-data">
                            @csrf -->
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
                            <!-- </form> -->
                            <!-- End Change Password Form -->
                        </div>
                    </div>
                    <!-- End Bordered Tabs -->
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{asset('extends/profile.js')}}"></script>
@endsection
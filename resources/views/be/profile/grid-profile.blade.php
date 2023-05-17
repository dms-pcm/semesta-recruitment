@extends('be.layout.index')
@section('content')

<div class="pagetitle">
    <h1>Profile</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/be-admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item">User</li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section profile">
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <img src="{{asset('be/assets/img/default-profile.jpg')}}" alt="Profile" class="rounded-circle" id="blah" />
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
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">
                                Overview
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

                            <!-- <div class="row">
                                <div class="col-lg-3 col-md-4 label">Perusahaan</div>
                                <div class="col-lg-9 col-md-8" id="company">-</div>
                            </div> -->

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
                    </div>
                    <!-- End Bordered Tabs -->
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    jQuery(document).ready(function () {
        $.ajax({
            url: `${urlApi}profile`,
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
            success: function (response) {
                console.log(response);
                let res = response?.data[0];
                if (res?.attachment != null) {
                    $("#blah").attr("src", `${baseUrl}storage/${res?.attachment}`);
                } else {
                    $("#blah").attr(
                        "src",
                        `${baseUrl}be/assets/img/default-profile.jpg`
                    );
                }
                
                if (res?.full_name != null) {
                    $("#name").text(res?.full_name);
                    $("#fullName").text(res?.full_name);
                } else {
                    $("#name").html(`<span class="badge bg-warning">Belum dimasukkan</span>`);
                    $("#fullName").html(`<span class="badge bg-warning">Belum dimasukkan</span>`);
                }
                // if (res?.company != null) {
                //     $("#sahaan").text(res?.company);
                //     $("#company").text(res?.company);
                // } else {
                //     $("#sahaan").html(`<span class="badge bg-warning">Belum dimasukkan</span>`);
                //     $("#company").html(`<span class="badge bg-warning">Belum dimasukkan</span>`);
                // }
                if (res?.country != null) {
                    $("#Country").text(res?.country);
                } else {
                    $("#Country").html(`<span class="badge bg-warning">Belum dimasukkan</span>`);
                }
                if (res?.address != null) {
                    $("#Address").text(res?.address);
                } else {
                    $("#Address").html(`<span class="badge bg-warning">Belum dimasukkan</span>`);
                }
                if (res?.phone != null) {
                    $("#Phone").text(res?.phone);
                } else {
                    $("#Phone").html(`<span class="badge bg-warning">Belum dimasukkan</span>`);
                }
                if (res?.email != null) {
                    $("#Email").text(res?.email);
                } else {
                    $("#Email").html(`<span class="badge bg-warning">Belum dimasukkan</span>`);
                }
                if (res?.twitter != null) {
                    $("#tw").attr("href", res?.twitter);
                    $("#tw").attr("target", "_blank");
                } else {
                    $("#tw").attr("href", "javascript:void(0)");
                }
                if (res?.facebook != null) {
                    $("#fb").attr("href", res?.facebook);
                    $("#fb").attr("target", "_blank");
                } else {
                    $("#fb").attr("href", "javascript:void(0)");
                }
                if (res?.instagram != null) {
                    $("#ig").attr("href", res?.instagram);
                    $("#ig").attr("target", "_blank");
                } else {
                    $("#ig").attr("href", "javascript:void(0)");
                }
            },
            error: function (xhr) {
                handleErrorSimpan(xhr);
            },
        });
    });
</script>
@endsection
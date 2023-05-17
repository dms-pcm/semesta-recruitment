@extends('fe.layout.index')
@section('content')
<!-- ======= Breadcrumbs ======= -->
<div class="breadcrumbs">
    <div class="page-header d-flex align-items-center" style="background-image: url('fe/assets/img/page-header.png');">
        <div class="container position-relative">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6 text-center">
                    <h2 class="title-h2">Informasi Rekrutmen</h2>
                    <p>Menyediakan beragam informasi mengenai rekrutmen secara up to date. Hanya di "SEMESTA recruitment" anda bisa menemukan banyak pekerjaan yang di inginkan.</p>
                </div>
            </div>
        </div>
    </div>
    <nav>
        <div class="container">
            <ol>
                <li><a href="{{url('/')}}">Home</a></li>
                <li>Informasi Rekrutmen</li>
            </ol>
        </div>
    </nav>
</div><!-- End Breadcrumbs -->

<!-- ======= About Us Section ======= -->
<section id="about" class="services">
    <div class="container" data-aos="fade-up">
        
        <div class="row gy-4" id="all-information">

            {{--<div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-img">
                        <img src="{{asset('fe/assets/img/storage-service.jpg')}}" data-fancybox="gallery" data-caption="Flayer" alt="" class="img-fluid" style="cursor:pointer;">
                    </div>
                    <h3><a href="javascript:void(0)" class="">loker pt indofood</a></h3>
                    <p class="deskripsi-loker">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid blanditiis eius nulla ipsa non temporibus nobis aspernatur cum rem...</p>
                    <div style="padding: 0 30px;">
                        <a href="{{url('/detail-information')}}" class="btn btn-primary float-end btn-detail-rekrutmen text-white" style="margin-bottom:30px;"><i class="bi bi-eye me-1"></i> Detail</a>
                    </div>
                </div>
            </div>--}}<!-- End Card Item -->

        </div>
        <div class="row d-flex justify-content-center d-none" id="nothing">
            <img src="{{asset('be/assets/img/nothing.png')}}" style="width:438px;margin-bottom:-20px" alt="Data tidak tersedia">
            <p class="text-center text-muted fs-5 mb-2" style="font-family:arial;">Mohon maaf...! Informasi rekrutmen belum tersedia!</p>
        </div>

    </div>
</section><!-- End About Us Section -->
<script src="{{asset('extends/fe/information.js')}}"></script>
<script>
    jQuery(document).ready(function () {
        $('#hero').addClass('d-none');
    });
</script>
@endsection
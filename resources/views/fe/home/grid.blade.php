@extends('fe.layout.index')
@section('content')
<!-- ======= Hero Section ======= -->
<section id="hero" class="hero d-flex align-items-center">
    <div class="container">
        <div class="row gy-4 d-flex justify-content-between">
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
                <h2 data-aos="fade-up">Solusi Tepat Untuk Mencari Pekerjaan</h2>
                <p data-aos="fade-up" data-aos-delay="100" style="font-family:poppins;">SEMESTA recruitment menyediakan
                    informasi seputar perekrutan oleh perusahaan ternama yang sudah bekerja sama dengan SMK Negeri 1
                    Tulungagung. Anda tidak perlu susah susah lagi mencari pekerjaan di luar sana, cukup dengan
                    menggunakan gadget dirumah, anda bisa melalukan pendaftaran rekrutmen.</p>

                <div class="row gy-4" data-aos="fade-up" data-aos-delay="400">

                    <div class="col-lg-3 col-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="200" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Mitra</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="100" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Rekrutmen</p>
                        </div>
                    </div><!-- End Stats Item -->

                    {{--<div class="col-lg-3 col-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="1453"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Support</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="32" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Workers</p>
                        </div>
                    </div><!-- End Stats Item -->--}}

                </div>
            </div>

            <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                <img src="{{asset('fe/assets/img/hero-img.svg')}}" class="img-fluid mb-3 mb-lg-0" alt="">
            </div>

        </div>
    </div>
</section><!-- End Hero Section -->

<main id="main">
    <section id="about" class="about">
        <div class="container" data-aos="fade-up">

            <div class="row gy-4">
                <div class="col-lg-6 position-relative align-self-start order-lg-last order-first">
                    <img src="{{asset('fe/assets/img/about.png')}}" class="img-fluid" alt="">
                    <a href="https://youtu.be/NZXps_KtgGk" class="glightbox play-btn"></a>
                </div>
                <div class="col-lg-6 content order-last  order-lg-first">
                    <h3 class="mb-3">Tentang Kami</h3>
                    <p>
                        BKK SMK merupakan salah satu komponen penting dalam mengukur keberhasilan pendidikan di SMK, karena BKK menjadi lembaga yang berperan mengoptimalkan penyaluran tamatan SMK dan sumber informasi untuk pencari kerja.
                    </p>
                    <ul>
                        <li data-aos="fade-up" data-aos-delay="100">
                            <i class="bi bi-diagram-3"></i>
                            <div>
                                <h5>Tujuan dibentuknya BKK</h5>
                                <p>
                                    <i class="bi bi-check" style="font-size:20px;margin-right:4px"></i>Sebagai wadah dalam mempertemukan tamatan dengan pencari kerja.
                                </p>
                                <p>
                                    <i class="bi bi-check" style="font-size:20px;margin-right:4px"></i>Memberikan layanan kepada tamatan sesuai dengan tugas dan fungsi masing-masing seksi yang ada dalam BKK.
                                </p>
                                <p>
                                    <i class="bi bi-check" style="font-size:20px;margin-right:4px"></i>Sebagai wadah dalam pelatihan tamatan yangs sesuai dengan permintaan pencari kerja.
                                </p>
                                <p>
                                    <i class="bi bi-check" style="font-size:20px;margin-right:4px"></i>Sebagai wadah untuk menanamkan jiwa wirausaha bagi tamatan melalui pelatihan.
                                </p>
                            </div>
                        </li>
                        {{--<li data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-fullscreen-exit"></i>
                            <div>
                                <h5>Magnam soluta odio exercitationem reprehenderi</h5>
                                <p>Quo totam dolorum at pariatur aut distinctio dolorum laudantium illo direna pasata
                                    redi</p>
                            </div>
                        </li>
                        <li data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-broadcast"></i>
                            <div>
                                <h5>Voluptatem et qui exercitationem</h5>
                                <p>Et velit et eos maiores est tempora et quos dolorem autem tempora incidunt maxime
                                    veniam</p>
                            </div>
                        </li>--}}
                    </ul>
                </div>
            </div>

        </div>
    </section><!-- End About Us Section -->
    <!-- ======= Services Section ======= -->
    <section id="service" class="services pt-0" style="padding-bottom:38px">
        <div class="container">

            <div class="section-header">
                <span>Informasi Rekrutmen</span>
                <h2>Informasi Rekrutmen</h2>

            </div>

            <div class="row gy-4" id="info-rekt">

                {{--<div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="card">
                        <div class="card-img">
                            <img src="{{asset('fe/assets/img/storage-service.jpg')}}" data-fancybox="gallery"
                data-caption="Flayer" alt="" class="img-fluid" style="cursor:pointer;">
            </div>
            <h3><a href="javascript:void(0)" class="">loker pt indofood</a></h3>
            <p class="deskripsi-loker">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid blanditiis eius
                nulla ipsa non temporibus nobis aspernatur cum rem...</p>
            <div style="padding: 0 30px;">
                <a href="{{url('/detail-information')}}"
                    class="btn btn-primary float-end btn-detail-rekrutmen text-white" style="margin-bottom:30px;"><i
                        class="bi bi-eye me-1"></i> Detail</a>
            </div>
        </div>
        </div>--}}
        <!-- End Card Item -->

        </div>
        <div class="row d-flex justify-content-center d-none" id="nothing">
            <img src="{{asset('be/assets/img/nothing.png')}}" style="width:438px;margin-bottom:-20px"
                alt="Data tidak tersedia">
            <p class="text-center text-muted fs-5 mb-2" style="font-family:arial;">Mohon maaf...! Informasi rekrutmen
                belum tersedia!</p>
        </div>
        <div id="row-btn-view-all">
            <!-- border-color: #2b497a; -->
            <a href="{{url('/information')}}" class="btn float-end mt-5 text-white btn-view-all"
                style="background-color: #2b497a;">Lihat Semua</a>
        </div>
        </div>
    </section><!-- End Services Section -->

    <!-- ======= Call To Action Section ======= -->
    {{--<section id="call-to-action" class="call-to-action">
        <div class="container" data-aos="zoom-out">

            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h3>Tentang Kami</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptas nostrum rerum qui deserunt,
                        nihil repellat assumenda saepe sit. Doloremque libero eius, totam possimus ipsa tempore
                        necessitatibus voluptates at iure. Dolore?</p>
                    <!-- <a class="cta-btn" href="#">Call To Action</a> -->
                </div>
            </div>

        </div>
    </section>--}}<!-- End Call To Action Section -->

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">
        <div class="container">
            <div class="section-header">
                <span>Keunggulan dan fitur</span>
                <h2>Keunggulan dan fitur</h2>

            </div>

            <div class="row gy-4 align-items-center features-item" data-aos="fade-up">

                <div class="col-md-5">
                    <img src="{{asset('fe/assets/img/pict1.png')}}" class="img-fluid" alt="">
                </div>
                <div class="col-md-7">
                    <h3>Keunggulan dari "SEMESTA recruitment"</h3>
                    <p class="fst-italic">
                        SEMESTA recruitment mempunyai beberapa keunggulan antara lain :
                    </p>
                    <ul style="font-family:poppins;font-size:16px;">
                        <li><i class="bi bi-check"></i>Menyediakan informasi rekrutmen secara <i
                                style="font-size:16px;">up to date</i></li>
                        <li><i class="bi bi-check"></i>Memiliki fitur yang belum terdapat pada aplikasi lainnya</li>
                        <li><i class="bi bi-check"></i>Pendaftaran rekrutmen bisa dilakukan secara fleksibel dan mudah
                        </li>
                    </ul>
                </div>
            </div><!-- Features Item -->

            <div class="row gy-4 align-items-center features-item" data-aos="fade-up">
                <div class="col-md-5 order-1 order-md-2">
                    <img src="{{asset('fe/assets/img/pict2.png')}}" class="img-fluid" alt="">
                </div>
                <div class="col-md-7 order-2 order-md-1">
                    <h3>Beberapa fitur pada aplikasi SEMESTA recruitment</h3>
                    <ul style="font-family:poppins;font-size:16px;">
                        <li><i class="bi bi-cursor-fill"></i>Fitur Daftar (Booking)</li>
                        <li><i class="bi bi-cursor-fill"></i>Fitur History Rekrutmen</li>
                        <li><i class="bi bi-cursor-fill"></i>Fitur Tracking Berkas</li>
                    </ul>
                </div>
            </div><!-- Features Item -->

        </div>
    </section><!-- End Features Section -->
</main><!-- End #main -->
<script src="{{asset('extends/fe/home.js')}}"></script>
@endsection
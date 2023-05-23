@extends('be.layout.index')
@section('content')

<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/be-admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
            <div class="row">

                <!-- Sales Card -->
                <div class="col-xxl-6 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Jumlah Rekrutmen</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-layers-half"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="countRect"></h6>
                                    <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-6 col-md-6">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">Jumlah User</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="countUser"></h6>
                                    <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->

                <!-- Customers Card -->
                {{--<div class="col-xxl-4 col-xl-12">

                    <div class="card info-card customers-card">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Customers <span>| This Year</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>1244</h6>
                                    <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>--}}<!-- End Customers Card -->

                <!-- Website Traffic -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Analisa Peserta Setiap Rekrutmen</h5>
                            
                            <div class="row">
                                <div class="col-md-5">
                                    <select class="selectpicker col-12" name="inputFilter" id="inputFilter" placeholder="Pilih rekrutmen" data-live-search="true">
                                       
                                    </select>
                                </div>
                                <div class="col-md-5 tampilkan">
                                    <button type="button" class="btn btn-primary mb-3" onclick="show()"><i class="bi bi-view-list me-1"></i> Tampilkan</button>
                                </div>
                            </div>
                            <div style="min-height: 400px;" class="d-none" id="grafik">
                                <canvas id="myGrafik" style="width:40%;height:auto;"></canvas>
                            </div>

                            <div class="row d-flex justify-content-center" id="selectRekrutmen">
                                <img src="{{asset('be/assets/img/option.png')}}" style="width:438px;margin-bottom:-20px" alt="Pilih rekrutmen">
                                <p class="text-center text-muted fs-5 mb-2" style="font-family:arial;">Silahkan pilih rekrutmen terlebih dahulu...</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Website Traffic -->
            </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

            <div class="card">

                <div class="card-body pb-0">

                    <h5 class="card-title">Analisa Peserta Semua Rekrutmen</h5>
                            
                    <div style="min-height: 400px;" id="chart">
                        <canvas id="myChart" style="width:40%;height:auto;"></canvas>
                    </div>

                    <div id="empty" class="text-center mb-4 d-none">
                        <div class="d-flex justify-content-center">
                            <img src="{{asset('fe/assets/img/data-empty.png')}}" style="width:50%" alt="Data Kosong">
                        </div>
                        <span class="text-muted" style="font-family:Poppins">Mohon maaf data belum tersedia.</span>
                    </div>

                </div>
            </div>
            
            <!-- News & Updates Traffic -->
            <div class="card"> <!-- style="padding-bottom: 25px;" -->

                <div class="card-body pb-0">
                    <h5 class="card-title">Rekrutmen Terbaru</h5>

                    <div class="news" id="content-body">

                    </div><!-- End sidebar recent posts-->
                    <div id="empty-data" class="text-center mb-4 d-none">
                        <div class="d-flex justify-content-center">
                            <img src="{{asset('fe/assets/img/data-empty.png')}}" style="width:50%" alt="Data Kosong">
                        </div>
                        <span class="text-muted" style="font-family:Poppins">Mohon maaf data belum tersedia.</span>
                    </div>

                </div>
            </div><!-- End News & Updates -->

        </div><!-- End Right side columns -->

    </div>
</section>
<script src="{{asset('extends/dashboard.js')}}"></script>
@endsection
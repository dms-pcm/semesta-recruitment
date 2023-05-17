@extends('be.layout.index')
@section('content')

<div class="pagetitle">
    <h1>Data User</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/be-admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Data User</li>
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
                            <h5 class="card-title">Daftar User</h5>
                            {{--<button type="button" class="btn btn-warning mb-3"><i class="bi bi-file-earmark-arrow-up-fill me-1"></i> Export</button>--}}

                            <table class="table w-100" id="tbl-user">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama User</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                {{--<tbody>
                                    <tr>
                                        <th scope="row"><a href="#">2457</a></th>
                                        <td>Brandon Jacob</td>
                                        <td><a href="#" class="text-primary">At praesentium minu</a></td>
                                        <td>$64</td>
                                        <td>
                                            <button type="button" class="btn btn-info"><i class="bi bi-eye-fill"></i></button>
                                            <button type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><a href="#">2147</a></th>
                                        <td>Bridie Kessler</td>
                                        <td><a href="#" class="text-primary">Blanditiis dolor omnis similique</a></td>
                                        <td>$47</td>
                                        <td>
                                            <button type="button" class="btn btn-info"><i class="bi bi-eye-fill"></i></button>
                                            <button type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><a href="#">2049</a></th>
                                        <td>Ashleigh Langosh</td>
                                        <td><a href="#" class="text-primary">At recusandae consectetur</a></td>
                                        <td>$147</td>
                                        <td>
                                            <button type="button" class="btn btn-info"><i class="bi bi-eye-fill"></i></button>
                                            <button type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><a href="#">2644</a></th>
                                        <td>Angus Grady</td>
                                        <td><a href="#" class="text-primary">Ut voluptatem id earum et</a></td>
                                        <td>$67</td>
                                        <td>
                                            <button type="button" class="btn btn-info"><i class="bi bi-eye-fill"></i></button>
                                            <button type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><a href="#">2644</a></th>
                                        <td>Raheem Lehner</td>
                                        <td><a href="#" class="text-primary">Sunt similique distinctio</a></td>
                                        <td>$165</td>
                                        <td>
                                            <button type="button" class="btn btn-info"><i class="bi bi-eye-fill"></i></button>
                                            <button type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
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

<div class="modal fade" id="view" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="bg-viewJadwal">
                    <div class="row detail-rekrutmen" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Nama</div>
                        <div class="col-lg-9 col-md-8" id="nama">-</div>
                    </div>
    
                    <div class="row detail-rekrutmen" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Email</div>
                        <div class="col-lg-9 col-md-8" id="email">-</div>
                    </div>

                    <div class="row detail-rekrutmen" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">No. Handphone</div>
                        <div class="col-lg-9 col-md-8" id="phone">-</div>
                    </div>
    
                    <div class="row detail-rekrutmen" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Twitter</div>
                        <div class="col-lg-9 col-md-8" id="tw">-</div>
                    </div>
    
                    <div class="row detail-rekrutmen" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Facebook</div>
                        <div class="col-lg-9 col-md-8" id="fb">-</div>
                    </div>
    
                    <div class="row detail-rekrutmen" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Instagram</div>
                        <div class="col-lg-9 col-md-8" id="ig">-</div>
                    </div>

                    <div class="row detail-rekrutmen" style="margin-bottom: 18px;">
                        <div class="col-lg-3 col-md-4 label fw-bold">Alamat</div>
                        <div class="col-lg-9 col-md-8" id="alamat">-</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('extends/users.js')}}"></script>
@endsection
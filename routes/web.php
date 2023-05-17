<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', function () {
    return view('login');
});

Route::get('register', function () {
    return view('register');
});

Route::get('/', function () {
    return view('fe.home.grid');
});

Route::get('information', function () {
    return view('fe.information-recruitment.grid');
})->name('informasi.rekrutmen');

Route::get('detail-information', function () {
    return view('fe.information-recruitment.detail');
});

Route::get('history', function () {
    return view('fe.information-recruitment.history');
})->name('riwayat.rekrutmen');

Route::get('profile', function () {
    return view('fe.profile.grid');
});

// Route::get('account-setting', function () {
//     return view('fe.profile.setting');
// });

Route::get('be-admin/dashboard', function () {
    return view('be.dashboard.grid');
});

Route::get('be-admin/persyaratan', function () {
    return view('be.persyaratan.grid');
});

Route::get('be-admin/rekrutmen', function () {
    return view('be.rekrutmen.grid');
});

Route::get('be-admin/data-peserta', function () {
    return view('be.data-peserta.grid');
})->name('data.peserta');

Route::get('be-admin/data-user', function () {
    return view('be.data-user.grid');
});

Route::get('be-admin/profile', function () {
    return view('be.profile.grid-profile');
});

Route::get('be-admin/settings', function () {
    return view('be.profile.grid-settings');
});
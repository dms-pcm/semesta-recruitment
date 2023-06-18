<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/email/verify/{id}/{hash}', function (Illuminate\Http\Request $request) {
    $user = \App\Models\User::find($request->route('id'));

    if ($user->hasVerifiedEmail()) {
        return view('already');
        // return response()->json(['message' => 'Email already verified']);
    }

    if ($user->markEmailAsVerified()) {
        event(new \Illuminate\Auth\Events\Verified($user));
    }

    return view('success');
    // return response()->json(['message' => 'Email verified successfully']);
})->middleware(['signed'])->name('verification.verify');

// Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
//     $user = $request->user();

//     if ($user->hasVerifiedEmail()) {
//         return response()->json(['message' => 'Email already verified']);
//     }

//     $user->sendEmailVerificationNotification();

//     return response()->json(['message' => 'Email verification link sent successfully']);
// })->middleware(['auth'])->name('verification.send');


Route::post('register', 'App\Http\Controllers\Api\AuthController@register');
Route::post('login', 'App\Http\Controllers\Api\AuthController@login');
Route::get('show','App\Http\Controllers\Api\RecruitmentController@showRekt');
Route::get('detail-rekt/{id}','App\Http\Controllers\Api\RecruitmentController@detail');
Route::get('persyaratan/show', 'App\Http\Controllers\Api\PersyaratanController@showSyaratFe');
Route::get('sosmed', 'App\Http\Controllers\Api\ProfileController@sosmed');
Route::group(['middleware' => ['jwt.verify', 'throttle:100,1']], function () {
    Route::post('logout', 'App\Http\Controllers\Api\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\Api\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\Api\AuthController@me');

    Route::group(['prefix' => 'recruitments'], function (){
        Route::get('/','App\Http\Controllers\Api\RecruitmentController@index');
        Route::get('syarat','App\Http\Controllers\Api\RecruitmentController@getSyarat');
        // Route::get('show','App\Http\Controllers\Api\RecruitmentController@showRekt');
        Route::post('create','App\Http\Controllers\Api\RecruitmentController@store');
        Route::post('update/{id}','App\Http\Controllers\Api\RecruitmentController@edit');
        // Route::post('quantity/{id}','App\Http\Controllers\Api\ParticipantController@updateQuantity');
        Route::post('done/{id}','App\Http\Controllers\Api\RecruitmentController@done');
        Route::get('detail/{id}','App\Http\Controllers\Api\RecruitmentController@detail');
        Route::delete('delete/{id}','App\Http\Controllers\Api\RecruitmentController@destroy');
    });

    Route::group(['prefix' => 'participants'], function (){
        Route::get('/','App\Http\Controllers\Api\ParticipantController@getParticipant');
        Route::get('title','App\Http\Controllers\Api\ParticipantController@getTitle');
        Route::post('filter','App\Http\Controllers\Api\ParticipantController@filter');
        Route::post('create','App\Http\Controllers\Api\ParticipantController@store');
        Route::post('file','App\Http\Controllers\Api\ParticipantController@storeData');
        Route::post('update/{id}','App\Http\Controllers\Api\ParticipantController@edit');
        Route::get('detail/{id}','App\Http\Controllers\Api\ParticipantController@detail');
        Route::delete('delete/{id}','App\Http\Controllers\Api\ParticipantController@destroy');
        Route::post('complete/{id}','App\Http\Controllers\Api\ParticipantController@completeFile');
        Route::post('incomplete/{id}','App\Http\Controllers\Api\ParticipantController@incompleteFile');
        Route::post('accept/{id}','App\Http\Controllers\Api\ParticipantController@lolos');
        Route::post('decline/{id}','App\Http\Controllers\Api\ParticipantController@tdkLolos');
        Route::get('/download/{id}', 'App\Http\Controllers\Api\ParticipantController@download');
        Route::get('preview/{id}', 'App\Http\Controllers\Api\ParticipantController@previewPdf');
    });

    Route::group(['prefix' => 'profile'], function (){
        Route::get('/', 'App\Http\Controllers\Api\ProfileController@profile');
        Route::post('update/{id}', 'App\Http\Controllers\Api\ProfileController@edit');
        Route::post('update-profile/{id}', 'App\Http\Controllers\Api\ProfileController@editProfile');
        Route::post('delete-picture/{id}', 'App\Http\Controllers\Api\ProfileController@deleteFoto');
        Route::post('change-password', 'App\Http\Controllers\Api\ProfileController@changePassword');
        Route::post('upload-cv', 'App\Http\Controllers\Api\ProfileController@uploadCV');
        Route::get('getCV/{id}', 'App\Http\Controllers\Api\ProfileController@getCV');
    });

    Route::group(['prefix' => 'history'], function (){
        Route::get('/', 'App\Http\Controllers\Api\HistoryController@historyParticipant');
    });

    Route::group(['prefix' => 'user'], function (){
        Route::get('/', 'App\Http\Controllers\Api\UserController@index');
        Route::get('detail/{id}', 'App\Http\Controllers\Api\UserController@detail');
        Route::delete('delete/{id}', 'App\Http\Controllers\Api\UserController@destroy');
    });

    Route::group(['prefix' => 'export'], function (){
        Route::get('/', 'App\Http\Controllers\Api\ExportController@exportData')->name('export.data');
        Route::get('data-hadir', 'App\Http\Controllers\Api\ExportController@dataHadir');
        Route::get('data-hadir-pdf', 'App\Http\Controllers\Api\ExportController@exportPDF');
    });

    Route::group(['prefix' => 'dashboard'], function (){
        Route::get('countRect', 'App\Http\Controllers\Api\DashboardController@countRecruitment');
        Route::get('countUser', 'App\Http\Controllers\Api\DashboardController@countUser');
        Route::get('chart', 'App\Http\Controllers\Api\DashboardController@chart');
        Route::get('grafik', 'App\Http\Controllers\Api\DashboardController@grafik');
        Route::get('newRekt', 'App\Http\Controllers\Api\DashboardController@newRekt');
    });

    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/', 'App\Http\Controllers\Api\NotificationController@index');
        Route::post('mark', 'App\Http\Controllers\Api\NotificationController@store');
        Route::post('markAll', 'App\Http\Controllers\Api\NotificationController@markAllAsRead');
    });

    Route::group(['prefix' => 'persyaratan'], function () {
        Route::get('/', 'App\Http\Controllers\Api\PersyaratanController@index');
        Route::get('detail/{id}', 'App\Http\Controllers\Api\PersyaratanController@detail');
        Route::post('store', 'App\Http\Controllers\Api\PersyaratanController@store');
        Route::post('edit/{id}', 'App\Http\Controllers\Api\PersyaratanController@edit');
        Route::delete('delete/{id}', 'App\Http\Controllers\Api\PersyaratanController@destroy');
    });
});

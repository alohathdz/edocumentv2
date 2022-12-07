<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CertificateTypeController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PresentController;
use App\Http\Controllers\ReceiveController;
use App\Http\Controllers\SendController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

//ผู้ดูแลระบบ
Route::middleware(['admin'])->group(function () {
    Route::resource('department', DepartmentController::class);
    Route::resource('user', UserController::class);
    Route::resource('certificateType', CertificateTypeController::class);
});
Route::get('/user/{id}/profile', [UserController::class, 'profile'])->name('user.profile');
Route::post('/user/{id}/profile/update', [UserController::class, 'profileUpdate'])->name('user.profile.update');

//เจ้าหน้าที่สารบรรณขึ้นไป
Route::middleware(['saraban'])->group(function () {
    Route::resource('receive', ReceiveController::class);
    Route::get('saraban', [ReceiveController::class, 'saraban'])->name('receive.saraban');
    Route::get('receive/{id}/view', [ReceiveController::class, 'view'])->name('receive.view');
});

//เจ้าหน้าที่ฝ่ายอำนวยการขึ้นไป
Route::middleware(['employee'])->group(function () {
    //หนังสือรับ
    Route::get('search/receive', [ReceiveController::class, 'homeSearch'])->name('receive.search.home');
    Route::post('search/receive', [ReceiveController::class, 'search'])->name('receive.search');
    //หนังสือส่ง
    Route::resource('send', SendController::class);
    Route::get('send/{id}/upload', [SendController::class, 'upload'])->name('send.upload');
    Route::get('search/send', [SendController::class, 'homeSearch'])->name('send.search.home');
    Route::post('search/send', [SendController::class, 'search'])->name('send.search');
    //หนังสือนำเรียน
    Route::resource('present', PresentController::class);
    Route::get('present/{id}/upload', [PresentController::class, 'upload'])->name('present.upload');
    Route::get('search/present', [PresentController::class, 'homeSearch'])->name('present.search.home');
    Route::post('search/present', [PresentController::class, 'search'])->name('present.search');
    //คำสั่ง
    Route::resource('command', CommandController::class);
    Route::get('command/{id}/upload', [CommandController::class, 'upload'])->name('command.upload');
    Route::get('search/command', [CommandController::class, 'homeSearch'])->name('command.search.home');
    Route::post('search/command', [CommandController::class, 'search'])->name('command.search');
    //หนังสือรับรอง
    Route::resource('certificate', CertificateController::class);
    Route::get('certificate/{id}/upload', [CertificateController::class, 'upload'])->name('certificate.upload');
    Route::get('search/certificate', [CertificateController::class, 'homeSearch'])->name('certificate.search.home');
    Route::post('search/certificate', [CertificateController::class, 'search'])->name('certificate.search');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/test', function () {
    $th = date_create_from_format("d/m/Y" ,"30/09/2565");
    $en = date("Y/m/d", $th);
    return $en;
});

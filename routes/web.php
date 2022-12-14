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
use App\Models\Receive;
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
    Route::get('receive/{id}/download', [ReceiveController::class, 'download'])->name('receive.download');
    Route::get('search/receive', [ReceiveController::class, 'homeSearch'])->name('receive.search.home');
    Route::post('search/receive', [ReceiveController::class, 'search'])->name('receive.search');
    //หนังสือส่ง
    Route::resource('send', SendController::class);
    Route::get('send/{id}/upload', [SendController::class, 'upload'])->name('send.upload');
    Route::get('send/{id}/download', [SendController::class, 'download'])->name('send.download');
    Route::get('search/send', [SendController::class, 'homeSearch'])->name('send.search.home');
    Route::post('search/send', [SendController::class, 'search'])->name('send.search');
    //หนังสือนำเรียน
    Route::resource('present', PresentController::class);
    Route::get('present/{id}/upload', [PresentController::class, 'upload'])->name('present.upload');
    Route::get('present/{id}/download', [PresentController::class, 'download'])->name('present.download');
    Route::get('search/present', [PresentController::class, 'homeSearch'])->name('present.search.home');
    Route::post('search/present', [PresentController::class, 'search'])->name('present.search');
    //คำสั่ง
    Route::resource('command', CommandController::class);
    Route::get('command/{id}/upload', [CommandController::class, 'upload'])->name('command.upload');
    Route::get('command/{id}/download', [CommandController::class, 'download'])->name('command.download');
    Route::get('search/command', [CommandController::class, 'homeSearch'])->name('command.search.home');
    Route::post('search/command', [CommandController::class, 'search'])->name('command.search');
    //หนังสือรับรอง
    Route::resource('certificate', CertificateController::class);
    Route::get('certificate/{id}/upload', [CertificateController::class, 'upload'])->name('certificate.upload');
    Route::get('certificate/{id}/download', [CertificateController::class, 'download'])->name('certificate.download');
    Route::get('search/certificate', [CertificateController::class, 'homeSearch'])->name('certificate.search.home');
    Route::post('search/certificate', [CertificateController::class, 'search'])->name('certificate.search');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/test', function () {
    $test = Receive::paginate(5);
    return auth()->user()->department->id;
});

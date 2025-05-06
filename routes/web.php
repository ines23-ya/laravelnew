<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RenevController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\PilihPengadaanController;
use App\Http\Controllers\PbjUploadController;
use App\Http\Controllers\KontruksiController;
use App\Http\Controllers\KontrakController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ReportPengadaanController;

// ✅ Flashscreen & Login
Route::get('/', fn() => view('flashscreen'))->name('flashscreen');
Route::get('/login', fn() => view('login'))->name('login');

// 🔐 Forgot Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// 🔐 Authentication
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/create', fn() => view('create'))->name('create');
Route::post('/create', [AuthController::class, 'register'])->name('register');
Route::get('/success', fn() => view('success'))->name('success');

// 🔐 Role-based Login
Route::get('/loginrenev', fn() => view('loginrenev'))->name('login.renev');
Route::post('/loginrenev', [AuthController::class, 'loginRenev'])->name('login.renev.post');

Route::get('/loginpengadaan', fn() => view('loginpengadaan'))->name('login.pengadaan');
Route::post('/loginpengadaan', [AuthController::class, 'loginPengadaan'])->name('login.pengadaan.post');

Route::get('/loginkeuangan', fn() => view('loginkeuangan'))->name('login.keuangan');
Route::post('/loginkeuangan', [AuthController::class, 'loginKeuangan'])->name('login.keuangan.post');

Route::get('/loginkontruksi', fn() => view('loginkontruksi'))->name('login.kontruksi');
Route::post('/loginkontruksi', [AuthController::class, 'loginKontruksi'])->name('login.kontruksi.post');

// ✅ Admin Login (Accessible without auth)
Route::get('/loginadmin', fn() => view('loginadmin'))->name('login.admin');
Route::post('/loginadmin', [AuthController::class, 'loginAdmin'])->name('login.admin.post');

// 📊 Dashboard
Route::get('/dashboard', fn() => view('dashboard'))->middleware('auth')->name('dashboard');

// 📁 Routes with Authentication
Route::middleware('auth')->group(function () {
    
    // 🔐 Logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');

    // 🧑‍💼 Admin
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::get('/admin/account/{id}', [AdminController::class, 'show'])->name('admin.account');
    Route::get('/haladmin', [AdminController::class, 'haladmin'])->name('haladmin');

    // 📌 Renev
    Route::get('/halrenev', [RenevController::class, 'index'])->name('halrenev');
    Route::post('/halrenev', [RenevController::class, 'store'])->name('halrenev.store');
    Route::get('/halrenev/hasil', [RenevController::class, 'hasil'])->name('halrenev.hasil');

    // 📁 Pengadaan
    Route::get('/pengadaan', fn() => view('pengadaan'))->name('pengadaan');
    Route::get('/pilihpengadaan', [PbjUploadController::class, 'create'])->name('pbj.create');
    Route::post('/pilihpengadaan', [PbjUploadController::class, 'store'])->name('pbj.store');
    Route::get('/hasilpengadaan', [PbjUploadController::class, 'index'])->name('hasil.pengadaan');
    Route::get('/download/{filename}', [PbjUploadController::class, 'download'])->name('pbj.download');

    // 🏗️ Kontruksi
    Route::get('/halkontruksi', [KontruksiController::class, 'index'])->name('halkontruksi');
    Route::post('/kontruksi/store', [KontruksiController::class, 'store'])->name('kontruksi.store');
    Route::get('/hasilkontrak', [KontruksiController::class, 'hasil'])->name('hasilkontrak');
    Route::get('/kontruksi/pilih', [KontruksiController::class, 'pilih'])->name('kontruksi.pilih');
    Route::get('/kontruksi/hasil', [KontruksiController::class, 'hasil'])->name('reports.hasilkontrak');
    Route::get('/kontrak/export-excel', [KontruksiController::class, 'exportExcel'])->name('kontrak.exportExcel');
Route::get('/kontrak/export-pdf', [KontruksiController::class, 'exportPDF'])->name('kontrak.exportPDF');


    // 📄 Kontrak
    Route::get('/kontrak/input', [KontrakController::class, 'create'])->name('kontrak.create');
    Route::post('/kontrak/store', [KontrakController::class, 'store'])->name('kontrak.store');
    Route::get('/kontrak', [KontrakController::class, 'index'])->name('kontrak.index');

    // 💰 Keuangan
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan');
    Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::get('/reportskeuangan', [PembayaranController::class, 'reports'])->name('reportskeuangan');
    Route::get('/export-keuangan-pdf', [PembayaranController::class, 'exportPdf'])->name('export.keuangan.pdf');
    Route::get('/export-keuangan-excel', [PembayaranController::class, 'exportExcel'])->name('export.keuangan.excel');

    // 📊 Reports
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/excel', [ReportsController::class, 'exportExcel'])->name('reports.export.excel');
    Route::get('/reports/export/pdf', [ReportsController::class, 'exportPDF'])->name('reports.export.pdf');

    // 📑 Reports Pengadaan
    Route::get('/reports/pengadaan', [ReportPengadaanController::class, 'index'])->name('pengadaan.reports');
    Route::get('/reports/pengadaan/export-excel', [ReportPengadaanController::class, 'exportExcel'])->name('pengadaan.export.excel');
    Route::get('/reports/pengadaan/export-pdf', [ReportPengadaanController::class, 'exportPDF'])->name('pengadaan.export.pdf');
    Route::get('/reports/pengadaan/download/{filename}', [ReportPengadaanController::class, 'download'])->name('pengadaan.download');

    
});

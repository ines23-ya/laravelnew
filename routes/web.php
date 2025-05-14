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
   
    Route::get('/admin/account/{id}', [AdminController::class, 'show'])->name('admin.account');
    Route::get('/haladmin', [AdminController::class, 'index'])->name('haladmin');
     Route::put('/admin/account/{id}', [AdminController::class, 'update'])->name('admin.account.update'); // Update account
    Route::delete('/admin/account/{id}', [AdminController::class, 'destroy'])->name('admin.account.delete'); // Delete account

   // 📌 Renev Routes
Route::get('/halrenev', [RenevController::class, 'index'])->name('halrenev');
Route::post('/halrenev', [RenevController::class, 'store'])->name('halrenev.store');
Route::get('/halrenev/hasil', [RenevController::class, 'hasil'])->name('halrenev.hasil');

// 📊 Renev Reports Routes (Editing and Managing Reports)
Route::get('/reports', [RenevController::class, 'reports'])->name('halrenev.reports');
Route::get('/reports/edit/{id}', [RenevController::class, 'reportsEdit'])->name('halrenev.reports.edit');
Route::put('/reports/update/{id}', [RenevController::class, 'reportsUpdate'])->name('halrenev.reports.update');
Route::delete('/reports/destroy/{id}', [RenevController::class, 'reportsDestroy'])->name('halrenev.reports.destroy'); // Fixed delete route
// 📊 Reports
Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
Route::get('/reports/export/excel', [ReportsController::class, 'exportExcel'])->name('reports.export.excel');
Route::get('/reports/export/pdf', [ReportsController::class, 'exportPDF'])->name('reports.export.pdf');

// 📊 Reports Export Routes
Route::get('/halrenev/export/excel', [ReportsController::class, 'exportExcel'])->name('halrenev.export.excel');
Route::get('/halrenev/export/pdf', [ReportsController::class, 'exportPDF'])->name('halrenev.export.pdf');



// Halaman utama pengadaan
Route::get('/pengadaan', [PbjUploadController::class, 'index'])->name('pengadaan');

// Formulir untuk memilih pengadaan
Route::get('/pengadaan/create', [PbjUploadController::class, 'create'])->name('pbj.create');

// Menyimpan data pengadaan
Route::post('/pilihpengadaan', [PbjUploadController::class, 'store'])->name('pbj.store');

// Laporan pengadaan
Route::get('/pengadaan/reports', [PbjUploadController::class, 'indexs'])->name('pengadaan.reports');

// Download dokumen
Route::get('/download/{filename}', [PbjUploadController::class, 'download'])->name('pbj.download');

// Edit pengadaan
Route::get('/pengadaan/edit/{id}', [PbjUploadController::class, 'edit'])->name('pengadaan.edit');

// Update pengadaan
Route::put('/pengadaan/update/{id}', [PbjUploadController::class, 'update'])->name('pengadaan.update');

// Hapus pengadaan
Route::delete('/pengadaan/destroy/{id}', [PbjUploadController::class, 'destroy'])->name('pengadaan.destroy');
// Route untuk download PDF
Route::get('/pengadaan/download/pdf', [PbjUploadController::class, 'downloadPdf'])->name('pengadaan.download.pdf');

// Route untuk download Excel
Route::get('/pengadaan/download/excel', [PbjUploadController::class, 'downloadExcel'])->name('pengadaan.download.excel');

//kontruksi

// Menampilkan halaman daftar kontruksi berdasarkan no_kontrak
Route::get('/halkontruksi', [KontruksiController::class, 'index'])->name('halkontruksi');

// Menyimpan data kontruksi
Route::post('/kontruksi/store', [KontruksiController::class, 'store'])->name('kontruksi.store');

// Menampilkan hasil kontruksi dan laporan
Route::get('/hasilkontrak', [KontruksiController::class, 'hasil'])->name('hasilkontrak'); // Pastikan nama rute adalah hasilkontrak

// Menampilkan halaman input kontruksi berdasarkan no_kontrak
Route::get('/kontruksi/inputkontruksi', [KontruksiController::class, 'inputkontruksi'])->name('halkontruksi.inputkontruksi');

// Export data kontruksi ke Excel
Route::get('/kontrak/export-excel', [KontruksiController::class, 'exportExcel'])->name('kontrak.exportExcel');
// Export data kontruksi ke PDF
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
    //Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/excel', [ReportsController::class, 'exportExcel'])->name('reports.export.excel');
    Route::get('/reports/export/pdf', [ReportsController::class, 'exportPDF'])->name('reports.export.pdf');

    
});

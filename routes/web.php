<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\LogAktivitasController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\ProfilSekolahController;
use App\Http\Controllers\Admin\SantriController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TagihanController as AdminTagihanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WaliSantriController;
use App\Http\Controllers\Bendahara\DashboardController as BendaharaDashboardController;
use App\Http\Controllers\Bendahara\TagihanController as BendaharaTagihanController;
use App\Http\Controllers\Bendahara\PembayaranController as BendaharaPembayaranController;
use App\Http\Controllers\Bendahara\LaporanController as BendaharaLaporanController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Wali\DashboardController as WaliDashboardController;
use App\Http\Controllers\Wali\InformasiController;
use App\Http\Controllers\Wali\NotifikasiController as WaliNotifikasiController;
use App\Http\Controllers\Wali\PembayaranController as WaliPembayaranController;
use App\Http\Controllers\Wali\TagihanController as WaliTagihanController;
use Illuminate\Support\Facades\Route;

// Landing Page Routes
Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/profil', [LandingPageController::class, 'profil'])->name('landing.profil');
Route::get('/berita', [LandingPageController::class, 'berita'])->name('landing.berita');
Route::get('/berita/{slug}', [LandingPageController::class, 'beritaDetail'])->name('landing.berita.detail');
Route::get('/galeri', [LandingPageController::class, 'galeri'])->name('landing.galeri');
Route::get('/kontak', [LandingPageController::class, 'kontak'])->name('landing.kontak');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Forgot Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'check.active'])->group(function () {
    // Profile Routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('users', UserController::class);
        
        // Wali Santri Management
        Route::get('/wali-santri', [WaliSantriController::class, 'index'])->name('wali-santri.index');
        Route::get('/wali-santri/create', [WaliSantriController::class, 'create'])->name('wali-santri.create');
        Route::post('/wali-santri', [WaliSantriController::class, 'store'])->name('wali-santri.store');
        Route::get('/wali-santri/generate', [WaliSantriController::class, 'showGenerateForm'])->name('wali-santri.generate');
        Route::post('/wali-santri/generate', [WaliSantriController::class, 'generateAkun'])->name('wali-santri.generate.store');
        Route::get('/wali-santri/{wali_santri}', [WaliSantriController::class, 'show'])->name('wali-santri.show');
        Route::get('/wali-santri/{wali_santri}/edit', [WaliSantriController::class, 'edit'])->name('wali-santri.edit');
        Route::put('/wali-santri/{wali_santri}', [WaliSantriController::class, 'update'])->name('wali-santri.update');
        Route::delete('/wali-santri/{wali_santri}', [WaliSantriController::class, 'destroy'])->name('wali-santri.destroy');
        Route::post('/wali-santri/{wali_santri}/reset-password', [WaliSantriController::class, 'resetPassword'])->name('wali-santri.reset-password');
        
        Route::resource('santri', SantriController::class);
        Route::resource('kelas', KelasController::class);
        Route::resource('jurusan', JurusanController::class);
        Route::resource('tagihan', AdminTagihanController::class);
        
        // Pembayaran admin hanya read-only (lihat saja)
        Route::get('/pembayaran', [AdminPembayaranController::class, 'index'])->name('pembayaran.index');
        Route::get('/pembayaran/{pembayaran}', [AdminPembayaranController::class, 'show'])->name('pembayaran.show');
        Route::get('/pembayaran/{pembayaran}/cetak', [AdminPembayaranController::class, 'cetakBukti'])->name('pembayaran.cetak');
        
        Route::resource('pengumuman', PengumumanController::class);

        Route::resource('kegiatan', KegiatanController::class);
        
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/transaksi', [LaporanController::class, 'transaksi'])->name('laporan.transaksi');
        Route::get('/laporan/tunggakan', [LaporanController::class, 'tunggakan'])->name('laporan.tunggakan');
        Route::get('/laporan/rekapitulasi', [LaporanController::class, 'rekapitulasi'])->name('laporan.rekapitulasi');
        
        Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log-aktivitas.index');
        
        // Pengaturan Payment Gateway
        Route::get('/pengaturan/payment', [\App\Http\Controllers\Admin\PengaturanPaymentController::class, 'index'])->name('pengaturan.payment.index');
        Route::put('/pengaturan/payment', [\App\Http\Controllers\Admin\PengaturanPaymentController::class, 'update'])->name('pengaturan.payment.update');
        Route::post('/pengaturan/payment/test', [\App\Http\Controllers\Admin\PengaturanPaymentController::class, 'testConnection'])->name('pengaturan.payment.test');
        
        // Landing Page Management
        Route::prefix('landing')->name('landing.')->group(function () {
            Route::get('/profil', [ProfilSekolahController::class, 'index'])->name('profil.index');
            Route::put('/profil', [ProfilSekolahController::class, 'update'])->name('profil.update');
            
            Route::resource('berita', BeritaController::class)->except(['show'])->parameters(['berita' => 'berita']);
            Route::resource('galeri', GaleriController::class)->except(['show']);
            Route::resource('slider', SliderController::class)->except(['show']);
        });
    });

    Route::middleware('role:bendahara')->prefix('bendahara')->name('bendahara.')->group(function () {
        Route::get('/dashboard', [BendaharaDashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/tagihan', [BendaharaTagihanController::class, 'index'])->name('tagihan.index');
        Route::get('/tagihan/create', [BendaharaTagihanController::class, 'create'])->name('tagihan.create');
        Route::post('/tagihan', [BendaharaTagihanController::class, 'store'])->name('tagihan.store');
        Route::get('/tagihan/{tagihan}', [BendaharaTagihanController::class, 'show'])->name('tagihan.show');
        Route::get('/tagihan/{tagihan}/edit', [BendaharaTagihanController::class, 'edit'])->name('tagihan.edit');
        Route::put('/tagihan/{tagihan}', [BendaharaTagihanController::class, 'update'])->name('tagihan.update');
        
        Route::get('/pembayaran', [BendaharaPembayaranController::class, 'index'])->name('pembayaran.index');
        Route::get('/pembayaran/create', [BendaharaPembayaranController::class, 'create'])->name('pembayaran.create');
        Route::post('/pembayaran', [BendaharaPembayaranController::class, 'store'])->name('pembayaran.store');
        Route::get('/pembayaran/{pembayaran}', [BendaharaPembayaranController::class, 'show'])->name('pembayaran.show');
        Route::get('/pembayaran/{pembayaran}/cetak', [BendaharaPembayaranController::class, 'cetakBukti'])->name('pembayaran.cetak');
        Route::get('/pembayaran/tagihan/{santri}', [BendaharaPembayaranController::class, 'getTagihanBySantri'])->name('pembayaran.tagihan');
        
        Route::get('/laporan', [BendaharaLaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/transaksi', [BendaharaLaporanController::class, 'transaksi'])->name('laporan.transaksi');
        Route::get('/laporan/tunggakan', [BendaharaLaporanController::class, 'tunggakan'])->name('laporan.tunggakan');
        Route::get('/laporan/rekapitulasi', [BendaharaLaporanController::class, 'rekapitulasi'])->name('laporan.rekapitulasi');
    });

    Route::middleware('role:wali_santri')->prefix('wali')->name('wali.')->group(function () {
        Route::get('/dashboard', [WaliDashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/tagihan', [WaliTagihanController::class, 'index'])->name('tagihan.index');
        Route::get('/tagihan/{tagihan}', [WaliTagihanController::class, 'show'])->name('tagihan.show');
        
        Route::get('/pembayaran', [WaliPembayaranController::class, 'index'])->name('pembayaran.index');
        Route::get('/pembayaran/{pembayaran}', [WaliPembayaranController::class, 'show'])->name('pembayaran.show');
        Route::get('/pembayaran/{pembayaran}/cetak', [WaliPembayaranController::class, 'cetakBukti'])->name('pembayaran.cetak');
        Route::get('/bayar/{tagihan}', [WaliPembayaranController::class, 'bayar'])->name('pembayaran.bayar');
        Route::post('/bayar/{tagihan}', [WaliPembayaranController::class, 'prosesBayar'])->name('pembayaran.proses');
        Route::get('/checkout/{pembayaran}', [WaliPembayaranController::class, 'checkout'])->name('pembayaran.checkout');
        Route::post('/pembayaran/{pembayaran}/verify', [WaliPembayaranController::class, 'verify'])->name('pembayaran.verify');
        Route::get('/konfirmasi/{pembayaran}', [WaliPembayaranController::class, 'konfirmasi'])->name('pembayaran.konfirmasi');
        
        Route::get('/pengumuman', [InformasiController::class, 'pengumuman'])->name('pengumuman.index');
        Route::get('/pengumuman/{pengumuman}', [InformasiController::class, 'showPengumuman'])->name('pengumuman.show');

        Route::get('/kegiatan', [InformasiController::class, 'kegiatan'])->name('kegiatan.index');
        Route::get('/kegiatan/{kegiatan}', [InformasiController::class, 'showKegiatan'])->name('kegiatan.show');
        
        // Notifikasi
        Route::get('/notifikasi', [WaliNotifikasiController::class, 'index'])->name('notifikasi.index');
        Route::get('/notifikasi/{notifikasi}', [WaliNotifikasiController::class, 'show'])->name('notifikasi.show');
        Route::post('/notifikasi/mark-all-read', [WaliNotifikasiController::class, 'markAllAsRead'])->name('notifikasi.mark-all-read');
        Route::get('/notifikasi-count', [WaliNotifikasiController::class, 'getUnreadCount'])->name('notifikasi.count');
        Route::get('/notifikasi-latest', [WaliNotifikasiController::class, 'getLatest'])->name('notifikasi.latest');
    });
});

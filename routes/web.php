<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/type/{type}', [HomeController::class, 'index'])->name('home.type');
Route::get('/images/{path}/{image}', [FileController::class, 'showImage']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'login_proces'])->name('loginAction');

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'register_proces'])->name('registerAction');
});

Route::middleware('auth')->group(function () {
    Route::prefix('keranjang')->group(function () {
        Route::get('/tambah/{productID}/{productPhotoTypesID?}', [HomeController::class, 'tambah_keranjang'])->name('keranjang.tambah_keranjang');
        Route::get('/hapus/{cart_index}', [HomeController::class, 'hapus_dari_keranjang'])->name('keranjang.hapus_dari_keranjang');
    });

    Route::prefix('bayar')->group(function () {
        Route::get('/proses', [PaymentController::class, 'pembayaran'])->name('bayar.proses');
        Route::get('/beli-langsung/proses/{productID}/{productPhotoTypesID?}', [PaymentController::class, 'proses_beli_langsung'])->name('bayar.proses_beli_langsung');
        Route::get('/beli-langsung/hapus', [PaymentController::class, 'hapus_beli_langsung'])->name('bayar.hapus_beli_langsung');
        Route::post('/proses-pembayaran', [PaymentController::class, 'proses_pembayaran'])->name('bayar.proses_pembayaran');
        Route::post('/proses-bukti-bayar/{orderID}', [PaymentController::class, 'proses_upload_bukti_bayar'])->name('bayar.proses_upload_bukti_bayar');
    });

    Route::get('/semua-orderan', [PaymentController::class, 'semua_orderan'])->name('semua_orderan');
    Route::get('/orderan-anda/{orderID}', [PaymentController::class, 'orderan_anda'])->name('orderan_anda');

    Route::get('/verify', [AuthController::class, 'verify'])->name('verify');
    Route::post('/verify', [AuthController::class, 'verify_proces'])->name('verifyAction');
    Route::get('/logout', function () {
        Auth::logout();

        return redirect('login');
    })->name('logout');
});

Route::middleware(['auth', 'role:store'])->group(function () {
    Route::prefix('toko')->group(function () {
        Route::get('/', [StoreController::class, 'beranda'])->name('store.beranda');
        Route::get('/tambah-produk', [StoreController::class, 'tambahProduk'])->name('store.tambah.produk');
        Route::get('/harga-produk/{productID}', [StoreController::class, 'ubahHargaProduk'])->name('store.tambah.harga.produk');
        Route::get('/harga-produk/{productID}/{productPriceID}', [StoreController::class, 'ubahHargaProduk'])->name('store.ubah.harga.produk');
        Route::get('/edit-produk/{productID}', [StoreController::class, 'editProduk'])->name('store.edit.produk');
        Route::get('/produk', [StoreController::class, 'dataProduk'])->name('store.produk');
        Route::get('/metode-pembayaran', [StoreController::class, 'metodePembayaran'])->name('store.metode.pembayaran');
        Route::get('/metode-pembayaran/ubah/{paymentMethodID}', [StoreController::class, 'metodePembayaran'])->name('store.ubah.metode.pembayaran');
        Route::get('/pesanan', [StoreController::class, 'pemesanan'])->name('store.pesanan');
        Route::get('/pesanan/{orderID}/{action}', [StoreController::class, 'proses_pesanan'])->name('store.proses_pesanan');
        Route::get('/laporan', [StoreController::class, 'laporan'])->name('store.laporan');

        // Post Route
        Route::post('/tambah-produk', [StoreController::class, 'tambah_produk'])->name('store.tambah_produk');
        Route::post('/edit-produk/{productID}', [StoreController::class, 'ubah_produk'])->name('store.ubah_produk');
        Route::post('/harga-produk/tambah/{productID}', [StoreController::class, 'tambah_harga_produk'])->name('store.tambah_harga_produk');
        Route::post('/harga-produk/ubah/{productPriceID}', [StoreController::class, 'ubah_harga_produk'])->name('store.ubah_harga_produk');
        Route::post('/metode-pembayaran', [StoreController::class, 'tambah_metode_pembayaran'])->name('store.tambah_metode_pembayaran');
        Route::post('/metode-pembayaran/ubah/{paymentMethodID}', [StoreController::class, 'ubah_metode_pembayaran'])->name('store.ubah_metode_pembayaran');
        Route::post('/laporan/make', [StoreController::class, 'buatLaporan'])->name('store.laporan.buat');

        // Delete Route
        Route::get('/hapus-harga-produk/{productPriceID}', [StoreController::class, 'hapus_harga_produk'])->name('store.hapus_harga_produk');
        Route::get('/metode-pembayaran/hapus/{paymentMethodID}', [StoreController::class, 'hapus_metode_pembayaran'])->name('store.hapus_metode_pembayaran');
    });
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/produk', [PageController::class, 'produk'])->name('produk');
Route::get('/produk/{id}', [PageController::class, 'produkDetail'])->name('produk.detail');
Route::post('/produk/{id}/tambah', [PageController::class, 'tambahKeranjang'])->name('produk.tambah');

Route::get('/keranjang', [PageController::class, 'keranjang'])->name('keranjang');
Route::post('/keranjang/update', [PageController::class, 'updateKeranjang'])->name('keranjang.update');
Route::post('/keranjang/hapus', [PageController::class, 'hapusKeranjang'])->name('keranjang.hapus');

Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [PageController::class, 'prosesCheckout'])->name('checkout.proses');

Route::get('/pesanan', [PageController::class, 'pesanan'])->name('pesanan');


// AUTH
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/login', [PageController::class, 'prosesLogin'])->name('login.proses');

Route::get('/register', [PageController::class, 'register'])->name('register');
Route::post('/register', [PageController::class, 'prosesRegister'])->name('register.proses');

Route::post('/logout', [PageController::class, 'logout'])->name('logout');


// AKUN
Route::get('/profil', [PageController::class, 'profil'])->name('profil');
Route::get('/loyalty', [PageController::class, 'loyalty'])->name('loyalty');


// LAINNYA
Route::get('/chat', [PageController::class, 'chat'])->name('chat');
Route::post('/chat/kirim', [PageController::class, 'kirimChat'])
    ->name('chat.kirim');
Route::get('/tentang', [PageController::class, 'tentang'])->name('tentang');
Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');

//profil
Route::get('/pesanan/{id}/review', [PageController::class, 'formReview'])
    ->name('review.form');

Route::post('/pesanan/{id}/review', [PageController::class, 'simpanReview'])
    ->name('review.simpan');
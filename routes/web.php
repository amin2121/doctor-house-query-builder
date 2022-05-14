<?php

use Illuminate\Support\Facades\Route;

Route::view('/about', 'about');
Route::view('/contact', 'contact');

// Route::get('/posts', 'PostController@index')->name('posts');
// Route::get('/posts/create', 'PostController@create')->name('posts.name');
// Route::post('/posts/store', 'PostController@store')->name('posts.store');
// Route::get('/posts/{post:slug}', 'PostController@show')->name('posts.show');
// Route::get('/posts/{post:slug}/edit', 'PostController@edit');
// Route::patch('/posts/{post:slug}/edit', 'PostController@update');
// Route::delete('/posts/{post:slug}/delete', 'PostController@destroy');

Route::prefix('posts')->group(function() {
    Route::get('/', 'PostController@index')->name('posts');
	Route::get('/create', 'PostController@create')->name('posts.name');
	Route::post('/store', 'PostController@store')->name('posts.store');
	Route::get('/{post:slug}', 'PostController@show')->name('posts.show');
	Route::get('/{post:slug}/edit', 'PostController@edit')->name('posts.edit');
	Route::patch('/{post:slug}/edit', 'PostController@update')->name('posts.update');
	Route::delete('/{post:slug}/delete', 'PostController@destroy')->name('posts.delete');
});

Route::get('/categories/{category:slug}', 'CategoryController@show');

Route::get('/tags/{tag:slug}', 'TagController@show');
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::prefix('jenis_obat')->group(function() {
	Route::get('/', 'JenisObatController@index')->name('jenis_obat');
	Route::post('/store', 'JenisObatController@store')->name('jenis_obat.store');
	Route::put('/edit', 'JenisObatController@edit')->name('jenis_obat.edit');
	Route::delete('/{id}/delete', 'JenisObatController@destroy')->name('jenis_obat.delete');
});

Route::prefix('supplier')->group(function() {
	Route::get('/', 'SupplierController@index')->name('supplier');
	Route::post('/store', 'SupplierController@store')->name('supplier.store');
	Route::put('/edit', 'SupplierController@edit')->name('supplier.edit');
	Route::delete('/{id}/delete', 'SupplierController@destroy')->name('supplier.delete');
});

Route::prefix('dokter')->group(function() {
	Route::get('/', 'DokterController@index')->name('dokter');
	Route::post('/store', 'DokterController@store')->name('dokter.store');
	Route::put('/edit', 'DokterController@edit')->name('dokter.edit');
	Route::delete('/{id}/delete', 'DokterController@destroy')->name('dokter.delete');
});

Route::prefix('obat')->group(function() {
	Route::get('/', 'ObatController@index')->name('obat');
	Route::post('/store', 'ObatController@store')->name('obat.store');
	Route::put('/edit', 'ObatController@edit')->name('obat.edit');
	Route::delete('/{id}/delete', 'ObatController@destroy')->name('obat.delete');
});

Route::prefix('pasien')->group(function() {
	Route::get('/', 'PasienController@index')->name('pasien');
	Route::post('/store', 'PasienController@store')->name('pasien.store');
	Route::put('/edit', 'PasienController@edit')->name('pasien.edit');
	Route::delete('/{id}/delete', 'PasienController@destroy')->name('pasien.delete');
});

Route::prefix('faktur-pembelian')->group(function() {
	Route::get('/', 'FakturPembelianController@index')->name('faktur-pembelian');
	Route::get('/create', 'FakturPembelianController@create')->name('faktur-pembelian.create');
	Route::post('/store', 'FakturPembelianController@store')->name('faktur-pembelian.store');
	Route::get('/show', 'FakturPembelianController@show')->name('faktur-pembelian.show');
});

Route::prefix('pemeriksaan-pasien')->group(function() {
	Route::get('/', 'PemeriksaanPasienController@create')->name('pemeriksaan-pasien');
	Route::post('/store', 'PemeriksaanPasienController@store')->name('pemeriksaan-pasien.store');
});

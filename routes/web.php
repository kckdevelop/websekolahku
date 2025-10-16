<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard');
});
Route::get('/galeri/galerifoto', function () {
    return view('pages.galeri.galerifoto');
});
Route::get('/profil/identitas', function () {
    return view('pages.profil.identitas');
});
Route::get('/galeri/galerivideo', function () {
    return view('pages.galeri.galerivideo');
});
Route::get('/jurusan/tkr', function () {
    return view('pages.jurusan.tkr');
});

Route::get('/informasi/spmb', function () {
    return view('pages.informasi.spmb');
});

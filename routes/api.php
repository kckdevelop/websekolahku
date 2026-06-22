<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\PrestasiController;

Route::get('/berita', [BeritaController::class, 'index']);
Route::get('/berita/{id_or_slug}', [BeritaController::class, 'show']);

Route::get('/prestasi', [PrestasiController::class, 'index']);
Route::get('/prestasi/{id}', [PrestasiController::class, 'show']);

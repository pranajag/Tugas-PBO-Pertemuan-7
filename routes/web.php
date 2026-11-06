<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\RuangController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::redirect('/', '/buku'); 

// Route::get('/buku', [BukuController::class, 'index'])
//       -> name('buku.index');

// Route::get('/buku/{id}', [BukuController::class, 'show'])
//       -> name('buku.show');


Route::get('/ruang', [RuangController::class, 'index'])
     ->name('ruang.index');

Route::get('/ruang/{kode}', [RuangController::class, 'show'])
     ->name('ruang.show');

Route::get('/peminjaman/{status?}', [RuangController::class, 'peminjaman'])
     ->name('ruang.peminjaman');
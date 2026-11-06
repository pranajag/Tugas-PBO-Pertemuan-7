<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index() {
        $daftarBuku = [
            ['id'=>1, 'judul'=>'Belajar PHP'],
            ['id'=>2, 'judul'=>'Dasar Laravel'],
        ];
        return view('buku.index', compact('daftarBuku'));
    }

    public function show(string $id) {
        return view('buku.show', compact('id'));
    }
}

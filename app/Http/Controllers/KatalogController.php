<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class KatalogController extends Controller
{
    
    
    Public function index(Request $request) : \Illuminate\View\View {
        $q = $request->input('q', '');

        $produk = [
        ['id' => 'BK-01',
        'nama' => 'Laskar Pelangi',
        'kategori' => 'Buku',
        'harga' => 20000,
        'stok' => 12,
        'status' => 'Aktif'],
        ['id' => 'BK-02',
        'nama' => 'Almon',
        'kategori' => 'Buku',
        'harga' => 20000,
        'stok' => 10,
        'status' => 'Aktif'],
        ['id' => 'BK-03',
        'nama' => 'Pen',
        'kategori' => 'Alat tulis',
        'harga' => 5000,
        'stok' => 20,
        'status' => 'Aktif'],
        ['id' => 'BK-04',
        'nama' => 'Janji',
        'kategori' => 'Buku',
        'harga' => 25000,
        'stok' => 14,
        'status' => 'Aktif'],
    ];

    $kategoriPilihan = $request->input('kategori');

    if (!empty($q)){
        $produk = array_filter($produk, function ($item) use ($q){
            return stripos($item['nama'], $q) !== false;
        });
    }



        return view('katalog.index',
        compact('produk'));
    }
}


// resources/views/katalog/
// index.blade.php

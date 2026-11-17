<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class KatalogController extends Controller
{
    
    
    Public function index(Request $request) : \Illuminate\View\View {
        $q = $request->input('q', '');

        $produk = [
        ['id' => 1,
        'nama' => 'Kopi Ende',
        'kategori' => 'Minuman',
        'harga' => 15000,
        'stok' => 12],
        ['id' => 2,
        'nama' => 'Roti Cokelat',
        'kategori' => 'Makanan',
        'harga' => 8000,
        'stok' => 0],
        ['id' => 3,
        'nama' => 'Mie Ayam',
        'kategori' => 'Makanan',
        'harga' => 15000,
        'stok' => 4],
        ['id' => 4,
        'nama' => 'Bakso Telur',
        'kategori' => 'Makanan',
        'harga' => 20000,
        'stok' => 10],
    ];

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

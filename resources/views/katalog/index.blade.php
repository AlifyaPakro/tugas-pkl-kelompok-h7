@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
    <link rel="stylesheet" href="{{ asset('resources/css/kasir.css') }}">

    <button>
        <a href="{{ route('katalog.index') }}">
        Back
        </a>
    </button>

    <h1>Katalog Produk</h1>
    <p>Harga dan stok toko</p>

    <form method="GET" action="{{ route('katalog.index') }}">
        <label for="q">Nama produk</label>
        <input id="q" name="q" value="{{ $q ?? '' }}">
        <button>Cari</button>
    </form>

    <br>
    <h2>Data Produk</h2>
    @forelse ($produk as $item)
        <p>{{ $item['nama'] }}</p>
        <p>Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
        <p>

            @if ($item['stok'] > 0)
                <span style="color : green">Stok : {{ $item['stok'] }} (Tersedia)</span>
            @else
                <span style=" color : red">Stok Habis</span>
            @endif
        </p>
        <hr>

    @empty
        <p>Produk tidak ditemukan.</p>
    @endforelse
@endsection



{{-- Contoh URL: /katalog?q=kopi --}}

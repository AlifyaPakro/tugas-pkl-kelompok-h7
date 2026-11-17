@extends('layouts.app')

@section('title', 'Pencarian Produk - Toko Buku Gramedia')

@section('content')
{{-- Pastikan Tailwind CSS sudah terpasang di layouts.app, atau gunakan CDN sementara di bawah ini jika belum --}}
{{-- <script src="https://cdn.tailwindcss.com"></script> --}}

<div class="min-h-screen bg-[#f4f4f4] text-[#222222] font-sans flex flex-col">

    {{-- Top Navbar --}}
    <header class="bg-white border-b border-gray-200 px-6 py-4 flex flex-wrap items-center justify-between gap-4">
        <div class="font-bold text-base tracking-wide uppercase text-gray-900">
            TOKO BUKU GRAMEDIA
        </div>
        <div class="text-xs text-gray-500 hidden sm:block">
            WIREFRAME &nbsp;&bull;&nbsp; Desktop &nbsp;&bull;&nbsp; Contoh data
        </div>
        <div class="text-xs font-semibold text-gray-800">
            Peran: Petugas toko
        </div>
    </header>

    {{-- Main Container --}}
    <div class="flex flex-1 flex-col md:flex-row">

        {{-- Sidebar --}}
        <aside class="w-full md:w-64 bg-[#ebebeb] border-b md:border-b-0 md:border-r border-gray-300 p-4 shrink-0">
            <div class="text-[11px] font-bold uppercase tracking-wider text-gray-500 px-3 mb-3">
                RUANG KERJA
            </div>
            <nav class="space-y-1 text-sm">
                <a href="{{ route('katalog.index') }}" class="block px-3 py-2.5 text-gray-700 hover:bg-gray-200/70 rounded transition">
                    Katalog produk
                </a>
                <a href="#" class="block px-3 py-2.5 text-gray-700 hover:bg-gray-200/70 rounded transition">
                    Rak &amp; lorong
                </a>
                <a href="{{ route('katalog.index') }}" class="block px-3 py-2.5 bg-[#d6d6d6] font-semibold text-gray-900 rounded">
                    Pencarian produk
                </a>
                <a href="#" class="block px-3 py-2.5 text-gray-700 hover:bg-gray-200/70 rounded transition">
                    Validasi stok
                </a>
                <a href="#" class="block px-3 py-2.5 text-gray-700 hover:bg-gray-200/70 rounded transition">
                    Kontrol rilis PM
                </a>
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-6 md:p-8 max-w-6xl">
            
            {{-- Breadcrumb / Header --}}
            <div class="mb-6">
                <div class="text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1">
                    WIREFRAME 05 &nbsp;&bull;&nbsp; PETUGAS TOKO
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                    Cari berdasarkan judul
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Mempercepat pengecekan ketersediaan buku melalui judul.
                </p>
                <p class="text-xs font-semibold text-gray-800 mt-1">
                    US-05 &bull; Pencarian berdasarkan judul buku
                </p>
            </div>

            {{-- Form Pencarian --}}
            <div class="bg-white border border-gray-200 p-5 mb-6 shadow-xs">
                <form method="GET" action="{{ route('katalog.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    <div class="md:col-span-6">
                        <label for="q" class="block text-xs font-semibold text-gray-800 mb-1.5">
                            Judul buku / nama produk
                        </label>
                        <input 
                            id="q" 
                            name="q" 
                            type="text"
                            value="{{ $q ?? '' }}" 
                            placeholder="Contoh: Laskar"
                            class="w-full border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:outline-none focus:border-gray-700"
                        >
                    </div>

                    <div class="md:col-span-4">
                        <label for="kategori" class="block text-xs font-semibold text-gray-800 mb-1.5">
                            Kategori
                        </label>
                        <select 
                            id="kategori" 
                            name="kategori" 
                            class="w-full border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:outline-none focus:border-gray-700"
                        >
                            <option value="">Semua kategori</option>
                            <option value="Buku" {{ request('kategori') == 'Buku' ? 'selected' : '' }}>Buku</option>
                            <option value="Alat tulis" {{ request('kategori') == 'Alat tulis' ? 'selected' : '' }}>Alat tulis</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <button 
                            type="submit" 
                            class="w-full bg-[#333333] hover:bg-black text-white text-xs font-semibold py-2.5 px-4 transition cursor-pointer"
                        >
                            Cari produk
                        </button>
                    </div>
                </form>
            </div>

            {{-- Grid Hasil Pencarian (Kiri) & Informasi Produk (Kanan) --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
                
                {{-- Kolom Kiri: Hasil Pencarian --}}
                <div class="lg:col-span-7 bg-white border border-gray-200 p-6 flex flex-col justify-between">
                    <div>
                        <h2 class="text-base font-bold text-gray-900">
                            Hasil pencarian &bull; {{ count($produk) }} produk aktif
                        </h2>
                        <p class="text-xs text-gray-500 mt-1 mb-4">
                            Pilih produk untuk melihat harga, stok, dan lokasi.
                        </p>

                        {{-- List Produk --}}
                        <div class="space-y-3">
                            @forelse ($produk as $index => $item)
                                <div 
                                    onclick="pilihProduk(this)"
                                    data-nama="{{ $item['nama'] }}"
                                    data-harga="Rp{{ number_format($item['harga'], 0, ',', '.') }}"
                                    data-stok="{{ $item['stok'] > 0 ? $item['stok'] . ' unit' : 'Stok habis' }}"
                                    data-rak="{{ $item['rak'] ?? 'A-03' }}"
                                    data-lorong="{{ $item['lorong'] ?? 'Lorong A' }}"
                                    data-kategori="{{ $item['kategori'] ?? 'Buku' }}"
                                    class="product-card cursor-pointer p-4 border transition {{ $index === 0 ? 'bg-[#e5e5e5] border-gray-400' : 'bg-[#f7f7f7] border-gray-200 hover:bg-[#ececec]' }}"
                                >
                                    <div class="font-bold text-base text-gray-900">
                                        {{ $item['nama'] }}
                                    </div>
                                    <div class="text-xs text-gray-600 mt-0.5">
                                        {{ $item['kode'] ?? 'BK-00' . ($index + 1) }} &nbsp;/&nbsp; {{ $item['kategori'] ?? 'Buku' }}
                                    </div>
                                    <div class="text-xs font-semibold mt-2">
                                        @if ($item['stok'] > 0)
                                            <span class="text-gray-900">Tersedia &bull; Lihat detail di sebelah kanan</span>
                                        @else
                                            <span class="text-red-600">Stok habis &bull; Lihat detail di sebelah kanan</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 bg-[#f5f5f5] border border-gray-200 text-sm text-gray-700">
                                    <p class="font-semibold">“Produk tidak ditemukan.”</p>
                                    <p class="text-xs text-gray-500 mt-1">Periksa judul atau ubah filter kategori.</p>
                                </div>
                            @endforelse
                        </div>

                        <p class="text-[11px] text-gray-500 mt-4">
                            Kategori tersedia: Semua, Buku, Alat tulis.
                        </p>
                    </div>

                    {{-- Info Box Bawah Kiri --}}
                    <div class="mt-6 bg-[#f2f2f2] p-4 border border-gray-200">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-gray-500 mb-1">
                            PENCARIAN JUDUL &bull; US-05
                        </div>
                        <p class="text-xs text-gray-700 leading-relaxed">
                            @if(!empty($q) && count($produk) > 0)
                                Kata kunci “{{ $q }}” menemukan {{ $produk[0]['nama'] }}. Pilih hasil untuk melihat ketersediaan buku.
                            @elseif(count($produk) > 0)
                                Menampilkan semua daftar produk aktif. Pilih hasil untuk melihat ketersediaan buku.
                            @else
                                Tidak ada produk yang cocok dengan kata kunci pencarian Anda.
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Kolom Kanan: Informasi Produk --}}
                <div class="lg:col-span-5 bg-white border border-gray-200 p-6">
                    <h2 class="text-base font-bold text-gray-900 mb-4">
                        Informasi produk
                    </h2>

                    @if(count($produk) > 0)
                        @php $first = $produk[0]; @endphp
                        <div id="detail-nama" class="text-base font-bold text-gray-900 mb-3">
                            {{ $first['nama'] }}
                        </div>

                        {{-- Harga Dasar --}}
                        <div class="bg-[#ececec] p-4 mb-3">
                            <div class="text-xs text-gray-600 mb-1">Harga dasar</div>
                            <div id="detail-harga" class="text-2xl font-bold text-gray-900">
                                Rp{{ number_format($first['harga'], 0, ',', '.') }}
                            </div>
                        </div>

                        {{-- Stok & Nomor Rak --}}
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="bg-[#ececec] p-4">
                                <div class="text-xs text-gray-600 mb-1">Stok tersisa</div>
                                <div id="detail-stok" class="text-lg font-bold {{ $first['stok'] > 0 ? 'text-gray-900' : 'text-red-600' }}">
                                    {{ $first['stok'] > 0 ? $first['stok'] . ' unit' : 'Stok habis' }}
                                </div>
                            </div>
                            <div class="bg-[#ececec] p-4">
                                <div class="text-xs text-gray-600 mb-1">Nomor rak</div>
                                <div id="detail-rak" class="text-lg font-bold text-gray-900">
                                    {{ $first['rak'] ?? 'A-03' }}
                                </div>
                            </div>
                        </div>

                        {{-- Lokasi & Kategori --}}
                        <div id="detail-lokasi" class="text-xs font-bold text-gray-800 mb-3">
                            {{ $first['lorong'] ?? 'Lorong A' }} &bull; Kategori {{ $first['kategori'] ?? 'Buku' }}
                        </div>

                        <p class="text-[11px] text-gray-500 leading-relaxed">
                            Data dibaca dari katalog dan stok dasar. Tidak ada transaksi pada tahap ini.
                        </p>
                    @else
                        <div class="bg-[#f5f5f5] p-6 text-center text-xs text-gray-500">
                            Belum ada produk yang dipilih untuk ditampilkan detailnya.
                        </div>
                    @endif
                </div>

            </div>

            {{-- Footer / Catatan Kondisi Kosong & Stok 0 --}}
            <div class="bg-[#eaeaea] border border-gray-200 p-5 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="text-[10px] font-bold uppercase tracking-wider text-gray-600 mb-1">
                        JIKA TIDAK DITEMUKAN
                    </div>
                    <p class="text-xs text-gray-800">
                        “Produk tidak ditemukan.”<br>
                        Periksa judul atau ubah filter kategori.
                    </p>
                </div>
                <div>
                    <div class="text-[10px] font-bold uppercase tracking-wider text-gray-600 mb-1">
                        JIKA STOK = 0
                    </div>
                    <p class="text-xs text-gray-800">
                        Tampilkan “Stok habis”. Produk nonaktif tidak muncul dalam pencarian aktif.
                    </p>
                </div>
            </div>

        </main>
    </div>
</div>

{{-- Script Interaktif untuk Memilih Produk & Update Panel Kanan --}}
<script>
    function pilihProduk(element) {
        // Reset warna semua kartu produk
        document.querySelectorAll('.product-card').forEach(card => {
            card.classList.remove('bg-[#e5e5e5]', 'border-gray-400');
            card.classList.add('bg-[#f7f7f7]', 'border-gray-200');
        });

        // Highlight kartu yang diklik
        element.classList.remove('bg-[#f7f7f7]', 'border-gray-200');
        element.classList.add('bg-[#e5e5e5]', 'border-gray-400');

        // Update data di panel sebelah kanan
        document.getElementById('detail-nama').textContent = element.dataset.nama;
        document.getElementById('detail-harga').textContent = element.dataset.harga;
        
        const stokEl = document.getElementById('detail-stok');
        stokEl.textContent = element.dataset.stok;
        if (element.dataset.stok === 'Stok habis') {
            stokEl.classList.remove('text-gray-900');
            stokEl.classList.add('text-red-600');
        } else {
            stokEl.classList.remove('text-red-600');
            stokEl.classList.add('text-gray-900');
        }

        document.getElementById('detail-rak').textContent = element.dataset.rak;
        document.getElementById('detail-lokasi').innerHTML = `${element.dataset.lorong} &bull; Kategori ${element.dataset.kategori}`;
    }
</script>
@endsection
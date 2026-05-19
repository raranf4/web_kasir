@extends('layouts.app')

@section('content')
<style>
    .search-kasir {
        background-color: #fff;
        border: 1px solid #ebdcd0;
        padding: 12px 18px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 500;
    }
    .search-kasir:focus {
        border-color: #2d1b10;
        box-shadow: none;
    }
    .btn-cari-kasir {
        background-color: #2d1b10;
        color: white;
        border: none;
        border-radius: 14px;
        padding: 12px 24px;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.2s;
    }
    .btn-cari-kasir:hover {
        background-color: #4e3629;
        color: white;
    }
    .card-katalog-kasir {
        background: white;
        border-radius: 22px;
        border: 1px solid #f7f3ed;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 15px rgba(45,27,16,0.01);
    }
    .card-katalog-kasir:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(45,27,16,0.05);
    }
    .img-kasir-container {
        position: relative;
        width: 100%;
        padding-top: 80%;
        background: #fdfbf7;
    }
    .img-kasir-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .btn-detail-kasir {
        background-color: #f7f3ed;
        color: #2d1b10;
        border: none;
        border-radius: 12px;
        padding: 8px 14px;
        font-weight: 700;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-detail-kasir:hover {
        background-color: #2d1b10;
        color: white;
    }
    .btn-cetak-menu {
        background-color: #d4a373;
        color: white;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13px;
        padding: 10px 18px;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
    }
    .btn-cetak-menu:hover {
        background-color: #b57c4c;
        color: white;
        box-shadow: 0 4px 12px rgba(212, 163, 115, 0.3);
    }
</style>

<div class="mb-4 d-flex justify-content-between align-items-end flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="material-icons-round text-muted" style="font-size: 20px;">point_of_sale</span>
            <h4 class="fw-bold m-0" style="font-weight: 800; color: #2d1b10; letter-spacing: -0.5px;">Katalog Etalase Kasir</h4>
        </div>
        <p class="text-muted small m-0">Silakan cek ketersediaan stok varian kue dan informasi detail produk di bawah ini.</p>
    </div>

    <div>
        <a href="{{ route('produk.cetak.menu') }}" class="btn-cetak-menu shadow-sm">
            <span class="material-icons-round" style="font-size: 18px;">print</span> Cetak Menu Kedai (Premium Layout)
        </a>
    </div>
</div>

<div class="mb-4">
    <form action="{{ route('user.produk.index') }}" method="GET" class="d-flex gap-2">
        <div class="position-relative flex-grow-1">
            <input type="text" name="search" class="form-control search-kasir w-100" placeholder="Ketik nama kue yang dicari pembeli..." value="{{ $search ?? request('search') }}">
        </div>
        <button type="submit" class="btn btn-cari-kasir d-flex align-items-center gap-2">
            <span class="material-icons-round" style="font-size: 18px;">search</span> Cari
        </button>
    </form>
</div>

<div class="row g-3">
    @forelse($produks as $p)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="card-katalog-kasir">
            <div class="img-kasir-container">
                @php
                    // Ambil isi kolom database resep foto milikmu
                    $pathFoto = $p->gambar ?? $p->foto_produk ?? $p->foto;
                @endphp

                @if($pathFoto)
                    <img src="{{ filter_var($pathFoto, FILTER_VALIDATE_URL) ? $pathFoto : asset($pathFoto) }}" alt="{{ $p->nama_produk }}">
                @else
                    <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=400" alt="SweetBakery Menu">
                @endif
            </div>
            
            <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                <div class="mb-3">
                    <span class="badge mb-2" style="font-size:9px; font-weight:700; background-color: #f7f3ed; color: #2d1b10;">
                        {{ strtoupper($p->kategori->nama_kategori ?? $p->kategori->kategori ?? 'Varian Roti') }}
                    </span>
                    <h6 class="fw-bold m-0 text-truncate" style="font-size:15px; color: #2d1b10; letter-spacing: -0.3px;">{{ $p->nama_produk }}</h6>
                    <span class="fw-bold d-block mt-1" style="font-size:15px; color: #d4a373;">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: #f7f3ed !important;">
                    @if($p->stok <= 0)
                        <span class="badge rounded-pill px-2 py-1" style="background-color: #ffe5e7; color: #e63946; font-size: 10px; font-weight: 700;">Habis ❌</span>
                    @elseif($p->stok <= 5)
                        <span class="badge rounded-pill px-2 py-1" style="background-color: #fefae0; color: #b77e00; font-size: 10px; font-weight: 700;">Sisa {{ $p->stok }} Pcs</span>
                    @else
                        <span class="text-muted fw-semibold" style="font-size: 11px;">Stok: <b class="text-dark">{{ $p->stok }} pcs</b></span>
                    @endif
                    
                    <a href="{{ route('user.produk.show', $p->id) }}" class="btn-detail-kasir">
                        Detail <span class="material-icons-round" style="font-size: 14px;">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center bg-white rounded-4 p-5 border text-muted small">
            🥮 Varian kue yang dicari tidak ditemukan di etalase toko.
        </div>
    </div>
    @endforelse
</div>
@endsection
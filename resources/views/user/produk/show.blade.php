@extends('layouts.app')

@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 85vh; padding: 20px;">
    
    <div class="card border-0 shadow-lg p-4" style="border-radius: 28px; max-width: 850px; width: 100%; background: #ffffff; animation: fadeInUp 0.4s ease-out;">
        
        <div class="row g-4 align-items-start">
            
            <div class="col-md-5">
                {{-- PERBAIKAN: Gunakan $produk->gambar sesuai dengan Controller --}}
                @if(isset($produk->gambar) && $produk->gambar)
                    <img src="{{ asset($produk->gambar) }}" class="img-fluid w-100 object-fit-cover shadow-sm" style="border-radius: 20px; height: 300px;" alt="{{ $produk->nama_produk }}">
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center w-100 text-muted" style="border-radius: 20px; height: 300px; background-color: #fcfaf7; border: 2px dashed #ebdcd0;">
                        <span class="material-icons-round" style="font-size: 54px; color: #d4a373; animation: bounce 2s infinite;">bakery_dining</span>
                        <small class="mt-2 fw-bold text-secondary" style="font-size: 13px; letter-spacing: 0.5px;">Tidak ada foto kue</small>
                    </div>
                @endif
            </div>

            <div class="col-md-7">
                <div class="ps-md-3">
                    <span class="badge px-3 py-2 rounded-pill mb-2 text-capitalize" style="background-color: #ebdcd0; color: #2d1b10; font-size: 11px; font-weight: 700; letter-spacing: 0.5px;">
                        ✨ {{ $produk->kategori->nama_kategori ?? 'Umum' }}
                    </span>
                    
                    <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">{{ $produk->nama_produk }}</h2>
                    <p class="text-muted small mb-3">Validasi stok terkini sistem kasir SweetBakery</p>

                    {{-- PERBAIKAN: Menambahkan Deskripsi Produk --}}
                    <div class="mb-4">
                        <small class="text-muted d-block fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px; text-transform: uppercase;">Deskripsi Produk</small>
                        <p class="text-secondary" style="font-size: 14px; line-height: 1.6;">
                            {{ $produk->deskripsi ?? 'Belum ada deskripsi untuk produk ini.' }}
                        </p>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="p-3 rounded-4 transition-hover" style="background-color: #fcfaf7; border: 1px solid rgba(45, 27, 16, 0.06);">
                                <small class="text-muted d-block fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px;">HARGA JUAL</small>
                                <span class="fw-bold text-success" style="font-size: 18px;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-4 transition-hover" style="background-color: #fcfaf7; border: 1px solid rgba(45, 27, 16, 0.06);">
                                <small class="text-muted d-block fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px;">STOK READY</small>
                                <span class="fw-bold {{ $produk->stok > 10 ? 'text-dark' : 'text-danger' }}" style="font-size: 18px;">{{ $produk->stok }} Pcs</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <a href="{{ route('user.produk.index') }}" class="btn py-2.5 fw-bold d-flex align-items-center justify-content-center gap-2 text-white shadow-sm transition-all" style="background-color: #2d1b10; border-radius: 14px; font-size: 14px;">
                            <span class="material-icons-round" style="font-size: 18px;">arrow_back</span>
                            Kembali ke Katalog Etalase
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: scale(0.95) translateY(15px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    .transition-hover:hover {
        background-color: #ffffff !important;
        border-color: #d4a373 !important;
        box-shadow: 0 4px 12px rgba(212, 163, 115, 0.1);
        transform: translateY(-2px);
    }
    .transition-all { transition: all 0.2s ease-in-out; }
    .transition-all:hover {
        background-color: #4a2c1b !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(45, 27, 16, 0.2) !important;
    }
</style>
@endsection
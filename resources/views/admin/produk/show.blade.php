@extends('layouts.app')

@section('content')
@php
    // =========================================================
    // LOGIKA AUTO-DETECT FOTO & DESKRIPSI LANGSUNG DI TEMPLATE
    // =========================================================
    
    // 1. Deteksi Otomatis Kolom Foto / Gambar
    $namaFoto = null;
    foreach (['foto_produk', 'foto', 'gambar', 'image', 'produk_foto'] as $kolomFoto) {
        if (!empty($produk->$kolomFoto)) {
            $namaFoto = $produk->$kolomFoto;
            break;
        }
    }
    
    $fotoFinal = $namaFoto && file_exists(public_path('storage/' . $namaFoto)) 
                ? asset('storage/' . $namaFoto) 
                : 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=500&auto=format&fit=crop&q=60';

    // 2. Deteksi Otomatis Kolom Deskripsi / Keterangan
    $teksDeskripsiFinal = null;
    foreach (['deskripsi', 'keterangan', 'detail', 'info', 'deskripsi_produk'] as $kolomDeskripsi) {
        if (!empty($produk->$kolomDeskripsi)) {
            $teksDeskripsiFinal = $produk->$kolomDeskripsi;
            break;
        }
    }
    
    if (empty($teksDeskripsiFinal)) {
        $teksDeskripsiFinal = 'Pemilik toko belum menambahkan rincian deskripsi resep khusus untuk produk varian kue manis ini.';
    }
@endphp

<div class="container-fluid" style="padding: 24px; font-family: 'Poppins', sans-serif;">
    <div class="mb-4">
        <a href="{{ route('admin.produk.index') }}" class="btn" style="background-color: #2d1b10; color: #fff; border-radius: 8px; font-weight: 500; padding: 8px 16px; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <i class="fas fa-arrow-left me-2"></i> ← Kembali ke Data Produk
        </a>
    </div>

    <div class="card border-0" style="border-radius: 16px; box-shadow: 0 10px 30px rgba(45, 27, 16, 0.08); overflow: hidden; background-color: #fff;">
        <div class="card-header border-0" style="background: linear-gradient(135deg, #2d1b10 0%, #4a2c1b 100%); padding: 20px 24px;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-1" style="color: #f7f3ed; font-weight: 600; letter-spacing: 0.5px;">Detail Varian Kue</h4>
                    <p class="mb-0" style="color: #d1c7bd; font-size: 13px;">Informasi spesifikasi dan deskripsi lengkap produk</p>
                </div>
                <span class="badge" style="background-color: #f7f3ed; color: #2d1b10; font-weight: 600; padding: 8px 16px; border-radius: 30px; font-size: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    ID Produk: #{{ $produk->id }}
                </span>
            </div>
        </div>

        <div class="card-body" style="padding: 40px 32px; background-color: #fdfbf9;">
            <div class="row g-5">
                
                <div class="col-lg-5 text-center">
                    <div style="position: relative; display: inline-block; padding: 10px; background-color: #fff; border: 1px solid #efeae4; border-radius: 20px; box-shadow: 0 8px 24px rgba(45, 27, 16, 0.05);">
                        <img src="{{ $fotoFinal }}" alt="{{ $produk->nama_produk }}" class="img-fluid" style="width: 100%; max-width: 380px; height: 320px; object-fit: cover; border-radius: 14px;">
                        
                        <div style="position: absolute; top: 24px; right: 24px;">
                            @if($produk->stok < 15)
                                <span class="badge bg-danger text-white px-3 py-2 rounded-pill shadow-sm" style="font-weight: 600; font-size: 12px; letter-spacing: 0.5px;">⚠️ STOK KRITIS</span>
                            @else
                                <span class="badge bg-success text-white px-3 py-2 rounded-pill shadow-sm" style="font-weight: 600; font-size: 12px; letter-spacing: 0.5px;">✓ STOK AMAN</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="d-flex align-items-center mb-3">
                        <h2 style="color: #2d1b10; font-weight: 700; margin-bottom: 0;">{{ $produk->nama_produk }}</h2>
                    </div>
                    
                    <p class="text-muted mb-4" style="font-size: 14px; line-height: 1.5;">
                        Koleksi varian menu eksklusif dari Sweet Bakery yang diolah menggunakan bahan premium higienis oleh chef profesional.
                    </p>

                    <div class="table-responsive">
                        <table class="table table-borderless" style="font-size: 15px;">
                            <tbody>
                                <tr style="border-bottom: 1px solid #efeae4;">
                                    <td style="width: 30%; padding: 14px 0; color: #8c7e74; font-weight: 500;">Kategori Menu</td>
                                    <td style="padding: 14px 0; color: #2d1b10; font-weight: 600;">
                                        <span class="px-3 py-1 rounded-pill" style="background-color: #f2ede6; font-size: 13px; color: #593e30;">
                                            {{ $produk->kategori->nama_kategori ?? 'Kue & Roti' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #efeae4;">
                                    <td style="padding: 14px 0; color: #8c7e74; font-weight: 500;">Harga Satuan</td>
                                    <td style="padding: 14px 0; color: #d96b27; font-weight: 700; font-size: 18px;">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #efeae4;">
                                    <td style="padding: 14px 0; color: #8c7e74; font-weight: 500;">Jumlah Stok Toko</td>
                                    <td style="padding: 14px 0; color: #2d1b10; font-weight: 600; font-size: 16px;">
                                        {{ $produk->stok }} <span style="font-size: 13px; color: #8c7e74; font-weight: 400;">Pcs (Varian Terbuka)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 14px 0; color: #8c7e74; font-weight: 500; vertical-align: top;">Deskripsi Rasa</td>
                                    <td style="padding: 14px 0; color: #403229; line-height: 1.6; text-align: justify;">
                                        {!! nl2br(e($teksDeskripsiFinal)) !!}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 pt-3 d-flex gap-2">
                        <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn text-white px-4 py-2" style="background-color: #d96b27; border-radius: 8px; font-weight: 500; font-size: 14px; transition: 0.3s;">
                            ✏️ Edit Kue
                        </a>
                        <button onclick="window.print();" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 8px; font-weight: 500; font-size: 14px;">
                            🖨️ Cetak Lembar Produk
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
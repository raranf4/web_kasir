@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- ================================================================== --}}
    {{-- 1. TAMPILAN DASHBOARD KHUSUS ADMIN (OTOMATIS & DINAMIS)            --}}
    {{-- ================================================================== --}}
    @if(Auth::check() && Auth::user()->role && Auth::user()->role->nama_role == 'admin')
        
        <div>
            <h2 class="fw-bold text-dark m-0">Statistik Toko Roti</h2>
            <p class="text-muted m-0 mb-4">Ringkasan estimasi nilai aset produk dan status limitasi stok barang</p>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm p-4 text-white" style="border-radius: 20px; background-color: #3b2314;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-white-50 fw-bold d-block mb-1" style="font-size: 11px;">ESTIMASI ASET PRODUK</small>
                            <h3 class="fw-bold m-0">Rp {{ number_format($estimasiAset, 0, ',', '.') }}</h3>
                        </div>
                        <span class="material-icons-round text-white-50" style="font-size: 32px;">layers</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm p-4 text-white" style="border-radius: 20px; background-color: #198754;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-white-50 fw-bold d-block mb-1" style="font-size: 11px;">TOTAL STOK INVENTORI</small>
                            <h3 class="fw-bold m-0">{{ $totalStok }} Pcs</h3>
                        </div>
                        <span class="material-icons-round text-white-50" style="font-size: 32px;">assignment_turned_in</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm p-4 text-white" style="border-radius: 20px; background-color: #dc3545;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-white-50 fw-bold d-block mb-1" style="font-size: 11px;">KRITIS BATAS RESTOCK</small>
                            <h3 class="fw-bold m-0">{{ $jumlahKritis }} Varian</h3>
                        </div>
                        <span class="material-icons-round text-white-50" style="font-size: 32px;">warning</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm p-4" style="border-radius: 20px; background-color: white;">
            <h5 class="fw-bold text-dark mb-4">Laporan Kontrol Batas Minimum Stok</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle m-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-3" style="font-size: 12px; font-weight: 800; color: #555;">NAMA PRODUK KUE</th>
                            <th class="py-3" style="font-size: 12px; font-weight: 800; color: #555;">KATEGORI</th>
                            <th class="py-3" style="font-size: 12px; font-weight: 800; color: #555;">HARGA SATUAN</th>
                            <th class="py-3" style="font-size: 12px; font-weight: 800; color: #555;">INDIKATOR SISA</th>
                            <th class="py-3 text-center" style="font-size: 12px; font-weight: 800; color: #555;">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produkKritis as $p)
                        <tr>
                            <td class="fw-bold px-3">{{ $p->nama_produk }}</td>
                            <td>
                                <span class="badge px-3 py-1.5 rounded-pill" style="background-color: #fcfaf7; color: #2d1b10; border: 1px solid #ebdcd0; font-size: 11px;">
                                    {{ $p->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="fw-bold">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                            <td style="width: 250px;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 6px;">
                                        {{-- Hitung persentase indikator bar sisa --}}
                                        <div class="progress-bar bg-danger" style="width: {{ min(($p->stok / 15) * 100, 100) }}%"></div>
                                    </div>
                                    <span class="text-danger fw-bold small">{{ $p->stok }} Pcs</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-danger-subtle text-danger px-3 py-1.5 rounded-pill border border-danger-subtle" style="font-size: 11px; font-weight: 700;">🚨 Kritis</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <span class="material-icons-round align-middle me-1" style="font-size: 18px;">check_circle</span>
                                Semua stok produk kue aman terkendali! Tidak ada yang di bawah 15 Pcs.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    {{-- ================================================================== --}}
    {{-- 2. TAMPILAN DASHBOARD KHUSUS USER / KASIR                          --}}
    {{-- ================================================================== --}}
    @else
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark m-0">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-muted m-0">Berikut adalah ringkasan aktivitas toko SweetBakery hari ini.</p>
            </div>
            <div class="badge bg-success px-3 py-2 rounded-pill" style="font-size: 14px;">
                <span class="material-icons-round align-middle me-1" style="font-size: 18px;">fiber_manual_record</span> 
                Sistem Kasir Aktif
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm p-4 text-white" style="border-radius: 20px; background: linear-gradient(135deg, #2d1b10, #4a2c1b);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="m-0 small text-white-50 fw-bold">TOTAL PENDAPATAN HARI INI</p>
                            <h3 class="fw-bold m-0 mt-1">Rp 1.450.000</h3>
                        </div>
                        <span class="material-icons-round text-white-50" style="font-size: 32px;">payments</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 20px; background-color: white; border-left: 5px solid #d4a373 !important;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="m-0 small text-muted fw-bold">TRANSAKSI KASIR</p>
                            <h3 class="fw-bold text-dark m-0 mt-1">24 Nota</h3>
                        </div>
                        <span class="material-icons-round" style="color: #d4a373; font-size: 32px;">receipt_long</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 20px; background-color: white; border-left: 5px solid #2d1b10 !important;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="m-0 small text-muted fw-bold">MENU TERLARIS</p>
                            <h3 class="fw-bold text-dark m-0 mt-1">Nastar Premium</h3>
                        </div>
                        <span class="material-icons-round" style="color: #2d1b10; font-size: 32px;">cake</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm p-4" style="border-radius: 20px; background-color: white;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark m-0">Riwayat Transaksi Terakhir (Shift Kamu)</h5>
                <a href="{{ route('user.produk.index') }}" class="btn btn-sm text-white px-3" style="background-color: #d4a373; border-radius: 10px;">
                    + Tambah Pesanan Baru
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle m-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-3">No. Nota</th>
                            <th class="py-3">Waktu</th>
                            <th class="py-3">Item Dibeli</th>
                            <th class="py-3">Total Bayar</th>
                            <th class="py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold px-3">#SB-9832</td>
                            <td>10 Menit yang lalu</td>
                            <td>2x Croissant Almond, 1x Choco Cookies</td>
                            <td class="fw-bold text-success">Rp 115.000</td>
                            <td class="text-center"><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">Selesai</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold px-3">#SB-9831</td>
                            <td>42 Menit yang lalu</td>
                            <td>1x Nastar Premium (Box)</td>
                            <td class="fw-bold text-success">Rp 150.000</td>
                            <td class="text-center"><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">Selesai</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold px-3">#SB-9830</td>
                            <td>1 Jam yang lalu</td>
                            <td>3x Roti Sobek Cokelat, 2x Donat Kampung</td>
                            <td class="fw-bold text-success">Rp 85.000</td>
                            <td class="text-center"><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">Selesai</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    @endif

</div>
@endsection
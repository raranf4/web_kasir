@extends('layouts.app')

@section('content')

@if(request()->query('view') === 'dashboard')
    <div class="mb-4">
        <h4 class="fw-bold m-0" style="font-weight: 800; color: #2d1b10; letter-spacing: -0.5px;">Ringkasan Toko</h4>
        <p class="text-muted small m-0">Kondisi performa inventori SweetBakery</p>
    </div>
    
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card p-4 border-0 rounded-4 bg-white" style="box-shadow: 0 4px 20px rgba(78,54,41,0.02); border-left: 5px solid #2d1b10 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1" style="font-size: 11px; color: #7d6b5e !important;">Estimasi Omset Etalase</span>
                        <h3 class="fw-bold m-0" style="font-weight: 800; color: #2d1b10;">Rp {{ number_format($estimasiAset ?? 0, 0, ',', '.') }}</h3>
                        <span class="badge rounded-pill small mt-2" style="font-size: 10px; background-color: #f7f3ed; color: #2d1b10;">Stabil</span>
                    </div>
                    <span class="material-icons-round p-3 rounded-4" style="font-size: 28px; color: #2d1b10; background-color: #f7f3ed;">payments</span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 border-0 rounded-4 bg-white" style="box-shadow: 0 4px 20px rgba(78,54,41,0.02); border-left: 5px solid #d4a373 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1" style="font-size: 11px; color: #7d6b5e !important;">Total Kuantitas Stok</span>
                        <h3 class="fw-bold m-0" style="font-weight: 800; color: #2d1b10;">{{ $totalStok ?? 0 }} Pcs</h3>
                        <span class="text-muted small d-block mt-2" style="font-size: 11px;">Kue siap jual</span>
                    </div>
                    <span class="material-icons-round p-3 rounded-4" style="font-size: 28px; color: #d4a373; background-color: #fefae0;">inventory</span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 border-0 rounded-4 bg-white" style="box-shadow: 0 4px 20px rgba(78,54,41,0.02); border-left: 5px solid #e63946 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1" style="font-size: 11px; color: #7d6b5e !important;">Kritis Restock</span>
                        <h3 class="fw-bold m-0" style="font-weight: 800; color: #e63946;">{{ $produkKritisCount ?? 0 }} Varian</h3>
                        <span class="text-danger small d-block mt-2" style="font-size: 11px; font-weight: 600;">Di bawah 15 pcs</span>
                    </div>
                    <span class="material-icons-round p-3 rounded-4" style="font-size: 28px; color: #e63946; background-color: #ffe5e7;">gpp_maybe</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 rounded-4 p-4 bg-white" style="box-shadow: 0 4px 24px rgba(0,0,0,0.015); border-radius: 24px;">
        <h6 class="fw-bold text-dark mb-3">Laporan Kontrol Batas Minimum Stok</h6>
        <div class="table-responsive">
            <table class="table align-middle table-borderless m-0">
                <thead>
                    <tr class="table-light text-secondary small text-uppercase" style="font-size: 11px; background-color: #f7f3ed;">
                        <th class="py-3 ps-3 rounded-start">Nama Produk Kue</th>
                        <th class="py-3">Kategori</th>
                        <th class="py-3">Harga Satuan</th>
                        <th class="py-3" width="220">Indikator Sisa</th>
                        <th class="py-3 text-end rounded-end pe-3">Status</th>
                    </tr>
                </thead>
                <tbody class="small fw-semibold" style="color: #2d1b10;">
                    @if(isset($produkKritis) && $produkKritis->count() > 0)
                        @foreach($produkKritis as $kritis)
                            @php
                                $persentase = min(($kritis->stok / 30) * 100, 100);
                                $warnaBar = $kritis->stok <= 7 ? 'background-color: #e63946;' : 'background-color: #d4a373;';
                                $warnaBadge = $kritis->stok <= 7 ? 'background-color: #ffe5e7; color: #e63946;' : 'background-color: #fefae0; color: #b77e00;';
                                $textStatus = $kritis->stok <= 7 ? '🚨 Kritis' : '⚠️ Perlu Restock';
                            @endphp
                            <tr class="border-bottom border-light">
                                <td class="fw-bold ps-3 py-3">{{ $kritis->nama_produk }}</td>
                                <td><span class="badge border-0 rounded-pill px-3 py-1" style="background-color: #f7f3ed; color: #2d1b10;">{{ $kritis->kategori->nama_kategori ?? 'Bakery' }}</span></td>
                                <td class="text-secondary">Rp {{ number_format($kritis->harga, 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress w-100" style="height: 6px; border-radius: 10px; background-color: #f1ebd9;">
                                            <div class="progress-bar" style="border-radius: 10px; {{ $warnaBar }} width: {{ $persentase }}%;"></div>
                                        </div>
                                        <span class="fw-bold" style="font-size:11px;">{{ $kritis->stok }} Pcs</span>
                                    </div>
                                </td>
                                <td class="text-end pe-3">
                                    <span class="badge rounded-pill px-3 py-1" style="font-weight: 700; {{ $warnaBadge }}">{{ $textStatus }}</span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">🥮 Semua stok aman di etalase toko.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@else
    <style>
        .search-input-clean { background-color: #fff; border: 1px solid #ebdcd0; padding: 11px 16px; border-radius: 12px; font-size: 13px; font-weight: 500; }
        .search-input-clean:focus { border-color: #2d1b10; box-shadow: none; }
        .select-clean { background-color: #fff; border: 1px solid #ebdcd0; padding: 11px 16px; border-radius: 12px; font-size: 13px; font-weight: 600; color: #5a4b40; }
        .btn-filter-dark { background-color: #2d1b10; color: white; border: none; border-radius: 12px; padding: 11px 20px; font-weight: 700; font-size: 13px; }
        .btn-add-premium { background-color: #2d1b10; color: white; border: none; border-radius: 12px; padding: 11px 18px; font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
        .btn-export-excel { background-color: #e2f0d9; color: #385723; border: none; border-radius: 12px; padding: 11px 16px; font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
        .btn-export-pdf { background-color: #fce4d6; color: #c65911; border: none; border-radius: 12px; padding: 11px 16px; font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
        .mini-card-product { background: white; border-radius: 20px; border: 1px solid #f7f3ed; overflow: hidden; display: flex; flex-direction: column; height: 100%; box-shadow: 0 4px 15px rgba(45,27,16,0.01); }
        .image-container-mini { position: relative; width: 100%; padding-top: 75%; background: #fafafa; }
        .image-container-mini img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
        .box-floating-control { position: absolute; top: 12px; right: 12px; display: flex; gap: 6px; }
        .btn-floating-circle { width: 32px; height: 32px; border-radius: 10px; background: rgba(255,255,255,0.96); border: none; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.05); text-decoration: none; }
        .body-card-mini { padding: 16px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
    </style>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold m-0" style="font-weight: 800; color: #2d1b10; letter-spacing: -0.5px;">Katalog Varian Bakery</h4>
            <p class="text-muted small m-0">Monitor visual produk, kontrol harga menu, dan sisa stok barang</p>
        </div>
        
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('admin.produk.export.excel') }}" class="btn-export-excel">
                <span class="material-icons-round" style="font-size:18px;">description</span> Excel
            </a>
            <a href="{{ route('admin.produk.export.pdf') }}" class="btn-export-pdf">
                <span class="material-icons-round" style="font-size:18px;">picture_as_pdf</span> PDF
            </a>
            <a href="{{ route('admin.produk.create') }}" class="btn-add-premium">
                <span class="material-icons-round" style="font-size: 18px;">add</span> Tambah Kue Baru
            </a>
        </div>
    </div>

    <div class="mb-4">
        <form action="{{ route('admin.produk.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-5">
                <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Cari nama kue manis...">
            </div>
    
            <div class="col-md-4">
                <select name="kategori_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- semua kategori -- <option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" {{ isset($kategori_id) && $kategori_id == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn text-white w-100" style="background-color: #2d1b10;">🔍 Filter</button>
                <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="row g-3">
        @forelse($produks as $p)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="mini-card-product">
                <div class="image-container-mini">
                    @if($p->gambar)
                        <img src="{{ asset($p->gambar) }}">
                    @else
                        <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=300">
                    @endif
                    <div class="box-floating-control">
                        <a href="{{ route('admin.produk.edit', $p->id) }}" class="btn-floating-circle text-warning"><span class="material-icons-round" style="font-size:16px;">edit</span></a>
                        <button onclick="pemicuHapus({{ $p->id }})" class="btn-floating-circle text-danger"><span class="material-icons-round" style="font-size:16px;">delete</span></button>
                    </div>
                </div>
                <div class="body-card-mini">
                    <div>
                        <span class="badge mb-2" style="font-size:9px; font-weight:700; background-color: #f7f3ed; color: #2d1b10;">{{ strtoupper($p->kategori->nama_kategori ?? 'ROTI') }}</span>
                        <h6 class="fw-bold m-0 text-truncate" style="font-size:14px; color: #2d1b10;">{{ $p->nama_produk }}</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top" style="border-color: #f7f3ed !important;">
                        <span class="fw-bold" style="font-size:14px; color: #2d1b10;">Rp{{ number_format($p->harga, 0, ',', '.') }}</span>
                        <span class="text-muted fw-semibold" style="font-size:11px;">Stok: {{ $p->stok }}</span>
                    </div>
                </div>
                <form id="form-hapus-{{ $p->id }}" action="{{ route('admin.produk.destroy', $p->id) }}" method="POST" class="d-none">@csrf @method('DELETE')</form>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center bg-white rounded-4 p-5 border text-muted small">🥮 Tidak ada resep roti kue dalam katalog.</div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $produks->appends(request()->query())->links() }}
    </div>
@endif

<div class="modal fade" id="hapusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content rounded-4 p-2 border-0">
            <div class="modal-body text-center p-3">
                <h6 class="fw-bold text-dark mb-1">Hapus Data Produk?</h6>
                <p class="text-muted small mb-4">Tindakan ini tidak dapat dibatalkan.</p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light btn-sm rounded-3 px-3 border" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="tombolKonfirmasiHapus" class="btn btn-danger btn-sm rounded-3 px-3">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
    @if(session('success'))
    <div id="toastSukses" class="toast align-items-center text-white border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #2a9d8f; border-radius: 16px;">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2 fw-semibold py-3" style="font-size: 13px;">
                <span class="material-icons-round">check_circle</span>
                {{ sessxion('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white m-auto me-3" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif
</div>

<script>
    let idTargetHapus = null;
    function pemicuHapus(id) {
        idTargetHapus = id;
        new bootstrap.Modal(document.getElementById('hapusModal')).show();
    }
    document.getElementById('tombolKonfirmasiHapus').addEventListener('click', function() {
        if(idTargetHapus) document.getElementById('form-hapus-' + idTargetHapus).submit();
    });

    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            let tSukses = new bootstrap.Toast(document.getElementById('toastSukses'));
            tSukses.show();
        @endif
    });
</script>
@endsection
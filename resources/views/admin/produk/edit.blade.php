@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 rounded-4 p-4 shadow-sm" style="max-width: 600px; margin: 0 auto;">
        <h5 class="fw-bold mb-1" style="color: #2d1b10;">Ubah Data Varian Kue</h5>
        <p class="text-muted small mb-4">Perbarui informasi resep, harga, deskripsi, atau foto etalase produk.</p>

        <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label small fw-bold">Nama Produk Kue</label>
                <input type="text" name="nama_produk" class="form-control" value="{{ $produk->nama_produk }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Kategori</label>
                <select name="kategori_id" class="form-select" required>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ $produk->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label small fw-bold">Harga Jual (Rp)</label>
                    <input type="number" name="harga" class="form-control" value="{{ intval($produk->harga) }}" required>
                </div>
                <div class="col-6">
                    <label class="form-label small fw-bold">Sisa Stok (Pcs)</label>
                    <input type="number" name="stok" class="form-control" value="{{ $produk->stok }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Deskripsi & Catatan Resep Varian</label>
                <textarea name="deskripsi" class="form-control" rows="4" placeholder="Tuliskan deskripsi kue di sini...">{{ $produk->deskripsi }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold">Ganti Foto Kue</label>
                <input type="file" name="gambar" class="form-control mb-2">
                @if($produk->gambar)
                    <div class="small text-muted">Foto saat ini: <span class="text-dark fw-bold">{{ basename($produk->gambar) }}</span></div>
                @endif
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.produk.index') }}" class="btn btn-light px-4 border small fw-bold">Batal</a>
                <button type="submit" class="btn text-white px-4 small fw-bold" style="background-color: #2d1b10;">Perbarui Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
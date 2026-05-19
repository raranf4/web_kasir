@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 rounded-4 p-4 shadow-sm" style="max-width: 600px; margin: 0 auto;">
        <h5 class="fw-bold mb-1" style="color: #2d1b10;">Tambah Varian Kue Baru</h5>
        <p class="text-muted small mb-4">Silakan isi formulir di bawah untuk memajang menu baru di etalase.</p>

        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold">Nama Produk Kue</label>
                <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" required placeholder="Contoh: Cromboloni Vanilla">
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Kategori</label>
                <select name="kategori_id" class="form-select" required>
                    <option value="">-- Pilih Kelompok Kategori --</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label small fw-bold">Harga Jual (Rp)</label>
                    <input type="number" name="harga" class="form-control" required placeholder="0">
                </div>
                <div class="col-6">
                    <label class="form-label small fw-bold">Stok Awal (Pcs)</label>
                    <input type="number" name="stok" class="form-control" required placeholder="0">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Deskripsi & Catatan Resep Varian</label>
                <textarea name="deskripsi" class="form-control" rows="4" placeholder="Tuliskan keunggulan rasa kue, bahan baku, atau info ketahanan kue di sini..."></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold">Upload Foto Kue</label>
                <input type="file" name="gambar" class="form-control">
                <span class="text-muted" style="font-size: 11px;">*Boleh dikosongkan dulu jika foto belum siap</span>
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.produk.index') }}" class="btn btn-light px-4 border small fw-bold">Batal</a>
                <button type="submit" class="btn text-white px-4 small fw-bold" style="background-color: #2d1b10;">Simpan Menu</button>
            </div>
        </form>
    </div>
</div>
@endsection
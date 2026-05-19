@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 d-flex align-items-center justify-content-center" style="background-color: #fdfbf7; min-height: 80vh;">
    <div class="w-100" style="max-width: 500px;">
        <div class="mb-4 text-center">
            <h4 class="fw-bold m-0" style="font-weight: 800; color: #2d1b10; letter-spacing: -0.5px;">Ubah Kelompok Kategori</h4>
            <p class="text-muted small m-0">Perbarui klasifikasi menu produk etalase tokomu</p>
        </div>

        <div class="card border-0 p-4 bg-white" style="border-radius: 24px; box-shadow: 0 10px 30px rgba(45,27,16,0.02);">
            <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="form-label small fw-bold text-uppercase" style="font-size: 11px; color: #7d6b5e; letter-spacing: 0.5px;">Nama Kelompok Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" 
                           value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required
                           style="background-color: #fcfbfa; border: 1px solid #ebdcd0; padding: 14px; border-radius: 16px; font-size: 13px; font-weight: 600; color: #2d1b10;">
                    @error('nama_kategori')
                        <div class="invalid-feedback small fw-semibold">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-3">
                    <a href="{{ route('admin.kategori.index') }}" class="btn py-3 fw-bold w-50 border-0" 
                       style="background-color: #f5f0eb; color: #7d6b5e; border-radius: 16px; font-size: 13px; text-decoration: none; text-align: center;">
                        Batal
                    </a>
                    <button type="submit" class="btn py-3 fw-bold text-white w-50 border-0" 
                            style="background-color: #2d1b10; border-radius: 16px; font-size: 13px;">
                        Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
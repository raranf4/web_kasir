@extends('layouts.app')

@section('content')
<div class="container-fluid" style="padding: 0; font-family: 'Plus Jakarta Sans', sans-serif;">
    
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '✨ Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: '⚠️ Perhatian!',
                text: "{{ $errors->first() }}",
            });
        </script>
    @endif

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 style="color: #2d1b10; font-weight: 700; margin-bottom: 4px;">Klasifikasi Kelompok Kategori</h3>
            <p class="text-muted mb-0" style="font-size: 14px;">Kelompokkan varian resep menu kue agar tertata rapi di mesin kasir</p>
        </div>
        <button type="button" class="btn text-white px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKategori" style="background-color: #2d1b10; border-radius: 8px; font-weight: 600; font-size: 14px; transition: 0.3s;">
            + Tambah Kelompok Baru
        </button>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden; background-color: #fff;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 15px;">
                    <thead style="background-color: #fdfbf9; border-bottom: 1px solid #efeae4;">
                        <tr>
                            <th class="text-center" style="width: 10%; padding: 18px; color: #8c7e74; font-weight: 600; font-size: 13px; text-transform: uppercase;">No</th>
                            <th style="width: 60%; padding: 18px; color: #8c7e74; font-weight: 600; font-size: 13px; text-transform: uppercase;">Nama Kelompok Kategori Kue</th>
                            <th class="text-center" style="width: 30%; padding: 18px; color: #8c7e74; font-weight: 600; font-size: 13px; text-transform: uppercase;">Aksi Pengelolaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $index => $kat)
                        <tr style="border-bottom: 1px solid #f7f5f2;">
                            <td class="text-center" style="padding: 16px; color: #403229; font-weight: 500;">{{ $index + 1 }}</td>
                            <td style="padding: 16px; color: #2d1b10; font-weight: 600;">
                                <span class="material-icons-round align-middle me-2" style="color: #8c7e74; font-size: 20px;">folder</span> 
                                {{ $kat->nama_kategori ?? $kat->kategori ?? $kat->nama }}
                            </td>
                            <td class="text-center" style="padding: 16px;">
                                <div class="d-inline-flex align-items-center gap-2">
                                    <a href="{{ route('admin.kategori.edit', $kat->id) }}" class="btn btn-sm px-3 py-1.5" style="background-color: #fff3cd; color: #664d03; border: 1px solid #ffe69c; border-radius: 6px; font-weight: 600; font-size: 13px; width: 75px; text-align: center; text-decoration: none;">
                                        Ubah
                                    </a>
                                    
                                    <form action="{{ route('admin.kategori.destroy', $kat->id) }}" method="POST" class="m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-delete px-3 py-1.5" style="background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; border-radius: 6px; font-weight: 600; font-size: 13px; width: 75px;">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <span class="material-icons-round d-block mb-2" style="font-size: 48px; color: #d1c7bd;">folder_open</span>
                                Belum ada data kelompok kategori terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahKategori" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 14px; border: none; box-shadow: 0 15px 50px rgba(0,0,0,0.15);">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #2d1b10 0%, #4a2c1b 100%); border-top-left-radius: 14px; border-top-right-radius: 14px; padding: 18px 24px;">
                <h5 class="modal-title id="modalTambahLabel" style="font-weight: 600; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                    <span class="material-icons-round">create_new_folder</span> Tambah Kelompok Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ url('/admin/kategori') }}" method="POST" class="m-0">
                @csrf
                <div class="modal-body" style="padding: 24px; background-color: #fdfbf9;">
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label" style="color: #403229; font-weight: 600; font-size: 14px;">Nama Kategori Kue</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Contoh: Donut Premium, Croissant" required autocomplete="off" style="border-radius: 8px; border: 1px solid #efeae4; padding: 10px 14px; font-size: 14px;">
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #fdfbf9; border-top: 1px solid #efeae4; padding: 16px 24px; border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;">
                    <button type="button" class="btn btn-light px-4 py-2" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 500; font-size: 14px;">Batal</button>
                    <button type="submit" class="btn text-white px-4 py-2" style="background-color: #d96b27; border-radius: 8px; font-weight: 600; font-size: 14px; box-shadow: 0 4px 10px rgba(217, 107, 39, 0.2);">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
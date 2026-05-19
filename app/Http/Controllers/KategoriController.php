<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // 1. Tampilkan Halaman Utama Kategori
    public function index()
    {
        $kategoris = Kategori::all();
        return view('admin.kategori.index', compact('kategoris'));
    }

    // 2. Proses Simpan Kategori Baru
    public function store(Request $request)
    {
    // Debugging: Ini akan memunculkan isi data yang dikirim ke layar
        dd($request->all()); 

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Berhasil!');
    }

    // 3. Tampilkan Form Edit Kategori (INI YANG KETINGGALAN TADI, RA!)
    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    // 4. Proses Update Perubahan Kategori
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Nama kelompok kategori berhasil diperbarui! ✨');
    }

    // 5. Proses Hapus Kategori
    public function destroy(Kategori $kategori)
    {
        // Cegah hapus jika kategori masih dipakai produk agar tidak error database
        if ($kategori->produks()->count() > 0) {
            return redirect()->route('admin.kategori.index')->with('error', 'Gagal! Kategori ini masih digunakan oleh beberapa produk kue di etalase.');
        }

        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kelompok kategori kue berhasil dihapus dari sistem! 🗑️');
    }
}
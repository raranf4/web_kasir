<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // ==========================================
    // AREA ADMIN: MANAJEMEN PRODUK
    // ==========================================
    public function indexAdmin(Request $request)
    {
        $query = Produk::query()->with('kategori');

        if ($request->filled('kategori_filter')) {
            $query->where('kategori_id', $request->kategori_filter);
        }

        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $produks = $query->paginate(12);
        $kategoris = Kategori::all();

        return view('admin.produk.index', compact('produks', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'kategori_id' => 'required',
            'deskripsi' => 'nullable|string', // Pastikan deskripsi ada
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $nama_gambar = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('uploads/produk'), $nama_gambar);
            $data['gambar'] = 'uploads/produk/' . $nama_gambar;
        }

        Produk::create($data);
        return redirect()->route('admin.produk.index')->with('success', 'Kue baru berhasil dipajang!');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('gambar')) {
            if ($produk->gambar && file_exists(public_path($produk->gambar))) {
                unlink(public_path($produk->gambar));
            }
            $nama_gambar = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('uploads/produk'), $nama_gambar);
            $data['gambar'] = 'uploads/produk/' . $nama_gambar;
        }

        $produk->update($data);
        return redirect()->route('admin.produk.index')->with('success', 'Data kue berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        if ($produk->gambar && file_exists(public_path($produk->gambar))) {
            unlink(public_path($produk->gambar));
        }
        $produk->delete();
        return redirect()->route('admin.produk.index')->with('success', 'Kue berhasil dihapus.');
    }

    // ==========================================
    // AREA ROLE: USER / KASIR
    // ==========================================

    public function userIndex(Request $request)
    {
        $search = $request->get('search');
        $kategori_filter = $request->get('kategori_filter');
        
        $produks = Produk::with('kategori')
            ->when($search, function($query) use ($search) {
                return $query->where('nama_produk', 'like', '%' . $search . '%');
            })
            ->when($kategori_filter, function($query) use ($kategori_filter) {
                return $query->where('kategori_id', $kategori_filter);
            })
            ->paginate(12);

        $kategoris = Kategori::all();
        return view('user.produk.index', compact('produks', 'kategoris'));
    }

    public function userShow($id)
    {
        // Pastikan load relasi kategori agar tidak error
        $produk = Produk::with('kategori')->findOrFail($id);
        return view('user.produk.show', compact('produk'));
    }

    public function cetakMenuKedai()
    {
        $produks = Produk::with('kategori')->orderBy('kategori_id', 'asc')->get();
        return view('user.produk.cetak_menu', compact('produks'));
    }
}
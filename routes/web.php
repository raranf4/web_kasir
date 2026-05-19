<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\Schema;

// ==========================================
// FORM LOGIN MANUAL & VALIDASI AMAN
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login'); 
    })->name('login');

    Route::post('/login', function () {
        $credentials = request()->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang dimasukkan salah, silakan cek kembali.',
        ]);
    });
});

// Halaman utama otomatis lempar ke dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// ==========================================
// SEMUA ROUTE YANG BUTUH LOGIN (AUTH)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // ==========================================
    // FIX DASHBOARD DINAMIS (ADMIN & KASIR)
    // ==========================================
    Route::get('/dashboard', function() {
        if (Auth::check() && Auth::user()->role && Auth::user()->role->nama_role == 'admin') {
            $totalStok = Produk::sum('stok'); 
            $estimasiAset = Produk::selectRaw('SUM(harga * stok) as total')->value('total') ?? 0; 

            $produkKritis = Produk::with('kategori')->where('stok', '<', 15)->get();
            $jumlahKritis = $produkKritis->count();

            return view('dashboard', compact('totalStok', 'estimasiAset', 'produkKritis', 'jumlahKritis'));
        }
        return view('dashboard');
    })->name('dashboard');

    Route::get('/produk/cetak-menu-kedai', [ProdukController::class, 'cetakMenuKedai'])->name('produk.cetak.menu');

    // ===================================================
    // CADANGAN JALUR CEPAT TAMBAH KATEGORI (AUTO-DETECT)
    // ===================================================
    Route::post('/kategori', function(Request $request) {
        $inputNama = $request->input('nama_kategori') ?? $request->input('kategori') ?? $request->input('nama');
        
        if (!$inputNama) {
            return back()->withErrors(['nama_kategori' => 'Input kategori tidak boleh kosong!']);
        }

        // Cari tahu apa nama kolom di tabel kategoris kamu sebenarnya
        $columns = Schema::getColumnListing('kategoris');
        $targetColumn = null;
        
        foreach (['nama_kategori', 'kategori', 'nama', 'nama_kategoris'] as $possibleColumn) {
            if (in_array($possibleColumn, $columns)) {
                $targetColumn = $possibleColumn;
                break;
            }
        }

        if ($targetColumn) {
            $kategori = new Kategori();
            $kategori->$targetColumn = $inputNama;
            $kategori->save();
            return back()->with('success', 'Kategori baru berhasil ditambahkan secara manual!');
        }

        return back()->withErrors(['error' => 'Kolom database tidak cocok!']);
    })->name('kategori.store');


    // ===================================================
    // GRUP ROUTE ADMIN (PRODUK & KATEGORI)
    // ===================================================
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // [1] ROUTE PRODUK ADMIN
        Route::get('/produk', function(Request $request) {
            if (Auth::check() && Auth::user()->role && Auth::user()->role->nama_role == 'admin') {
                $search = $request->get('search');
                $kategori_id = $request->get('kategori_id'); 
                
                $totalStok = Produk::sum('stok'); 
                $estimasiAset = Produk::selectRaw('SUM(harga * stok) as total')->value('total') ?? 0; 
                
                $produkKritis = Produk::with('kategori')->where('stok', '<', 15)->get();
                $produkKritisCount = $produkKritis->count();
                $kategoris = Kategori::all();

                $produks = Produk::with('kategori')
                    ->when($search, function($query) use ($search) {
                        return $query->where('nama_produk', 'like', '%' . $search . '%');
                    })
                    ->when($kategori_id, function($query) use ($kategori_id) {
                        return $query->where('kategori_id', $kategori_id); 
                    })
                    ->paginate(8)
                    ->withQueryString(); 

                return view('admin.produk.index', compact('produks', 'search', 'kategori_id', 'totalStok', 'estimasiAset', 'produkKritis', 'produkKritisCount', 'kategoris'));
            }
            return redirect('/dashboard');
        })->name('produk.index');
        
        Route::get('/produk/create', function() {
            if (Auth::check() && Auth::user()->role && Auth::user()->role->nama_role == 'admin') {
                return app(ProdukController::class)->create();
            }
            return redirect('/dashboard');
        })->name('produk.create');

        // Export Excel CSV murni
        Route::get('/produk/export/excel', function(Request $request) {
            if (Auth::check() && Auth::user()->role && Auth::user()->role->nama_role == 'admin') {
                $produks = Produk::with('kategori')->get();
                $filename = "Laporan_Stok_SweetBakery_" . date('Y-m-d') . ".csv";
                $csvData = "\xEF\xBB\xBF";
                $csvData .= "No;Nama Produk Kue;Kategori;Harga Satuan;Sisa Stok\n";
                
                foreach ($produks as $index => $p) {
                    $no = $index + 1;
                    $nama = str_replace(';', ',', $p->nama_produk);
                    $kategori = str_replace(';', ',', $p->kategori->nama_kategori ?? 'Bakery');
                    $harga = $p->harga;
                    $stok = $p->stok;
                    $csvData .= "{$no};{$nama};{$kategori};{$harga};{$stok}\n";
                }
                
                return response($csvData)
                    ->header('Content-Type', 'text/csv; charset=utf-8')
                    ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->header('Cache-Control', 'max-age=0');
            }
            return redirect('/dashboard');
        })->name('produk.export.excel');
        
        // Export PDF
        Route::get('/produk/export/pdf', function(Request $request) {
            if (Auth::check() && Auth::user()->role && Auth::user()->role->nama_role == 'admin') {
                $produks = Produk::with('kategori')->get();
                
                $html = '
                <div style="font-family: sans-serif; padding: 20px;">
                    <h2 style="text-align: center; color: #2d1b10; margin-bottom: 5px;">SWEETBAKERY REPORT</h2>
                    <p style="text-align: center; margin-top: 0; color: #666; font-size: 12px;">Laporan Data Stok Varian Kue Terupdate</p>
                    <hr style="border: 1px solid #2d1b10; margin-bottom: 20px;">
                    <table border="1" cellspacing="0" cellpadding="8" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                        <tr style="background-color: #f7f3ed; color: #2d1b10;">
                            <th>No</th>
                            <th>Nama Produk Kue</th>
                            <th>Kategori</th>
                            <th>Harga Satuan</th>
                            <th>Sisa Stok</th>
                        </tr>';
                
                foreach ($produks as $index => $p) {
                    $html .= '
                        <tr>
                            <td style="text-align: center;">'.($index + 1).'</td>
                            <td style="font-weight: bold;">'.e($p->nama_produk).'</td>
                            <td>'.e($p->kategori->nama_kategori ?? 'Bakery').'</td>
                            <td>Rp '.number_format($p->harga, 0, ',', '.').'</td>
                            <td style="text-align: center; font-weight: bold;">'.$p->stok.' Pcs</td>
                        </tr>';
                }
                
                $html .= '
                    </table>
                    <script>
                        window.print();
                        window.onafterprint = function() {
                            window.location.href = "'.route('admin.produk.index').'";
                        };
                        setTimeout(function() {
                            window.location.href = "'.route('admin.produk.index').'";
                        }, 300);
                    </script>
                </div>';
                
                return response($html);
            }
            return redirect('/dashboard');
        })->name('produk.export.pdf');

        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        
        // Detail Varian Kue Auto-Detect
        Route::get('/produk/{produk}', function($id) {
            if (Auth::check() && Auth::user()->role && Auth::user()->role->nama_role == 'admin') {
                $produk = Produk::with('kategori')->findOrFail($id);
                
                $namaFoto = null;
                foreach (['foto_produk', 'foto', 'gambar', 'image', 'produk_foto'] as $kolomFoto) {
                    if (!empty($produk->$kolomFoto)) {
                        $namaFoto = $produk->$kolomFoto;
                        break;
                    }
                }
                $fotoPath = $namaFoto && file_exists(public_path('storage/' . $namaFoto)) 
                            ? asset('storage/' . $namaFoto) 
                            : 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=500&auto=format&fit=crop&q=60';

                $teksDeskripsi = null;
                foreach (['deskripsi', 'keterangan', 'detail', 'info', 'deskripsi_produk'] as $kolomDeskripsi) {
                    if (!empty($produk->$kolomDeskripsi)) {
                        $teksDeskripsi = $produk->$kolomDeskripsi;
                        break;
                    }
                }
                if (empty($teksDeskripsi)) {
                    $teksDeskripsi = 'Pemilik toko belum menambahkan rincian deskripsi resep khusus untuk produk varian kue manis ini.';
                }

                return view('admin.produk.show', compact('produk', 'fotoPath', 'teksDeskripsi'));
            }
            return redirect('/dashboard');
        })->name('produk.show');

        Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');


        // [2] ROUTE KATEGORI ADMIN (AUTO-DETECT JUGA SAAT SIMPAN)
        Route::get('/kategori', function() {
            if (Auth::check() && Auth::user()->role && Auth::user()->role->nama_role == 'admin') {
                $kategoris = Kategori::all();
                return view('admin.kategori.index', compact('kategoris'));
            }
            return redirect('/dashboard');
        })->name('kategori.index');

        Route::post('/kategori', function(Request $request) {
            $inputNama = $request->input('nama_kategori') ?? $request->input('kategori') ?? $request->input('nama');
            
            $columns = Schema::getColumnListing('kategoris');
            $targetColumn = null;
            foreach (['nama_kategori', 'kategori', 'nama', 'nama_kategoris'] as $possibleColumn) {
                if (in_array($possibleColumn, $columns)) {
                    $targetColumn = $possibleColumn;
                    break;
                }
            }

            if ($targetColumn) {
                $kategori = new Kategori();
                $kategori->$targetColumn = $inputNama;
                $kategori->save();
                return back()->with('success', 'Kategori baru berhasil ditambahkan secara manual!');
            }
            return back()->withErrors(['error' => 'Kolom database tidak cocok!']);
        })->name('kategori.store');

        Route::get('/kategori/{id}/edit', function($id) {
            $kategori = Kategori::findOrFail($id);
            return view('admin.kategori.edit', compact('kategori'));
        })->name('kategori.edit');

        Route::put('/kategori/{id}', function(Request $request, $id) {
            $data = $request->validate(['nama_kategori' => 'required|string|max:255']);
            Kategori::findOrFail($id)->update($data);
            return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diubah!');
        })->name('kategori.update');

        Route::delete('/kategori/{id}', function($id) {
            Kategori::findOrFail($id)->delete();
            return back()->with('success', 'Kategori berhasil dihapus!');
        })->name('kategori.destroy');
    });

    // Grup Route Kasir / User Biasa
    Route::get('/user/produk', [ProdukController::class, 'userIndex'])->name('user.produk.index');
    Route::get('/user/produk/{id}', [ProdukController::class, 'userShow'])->name('user.produk.show');
});

// ==========================================
// ROUTE LOGOUT AMAN
// ==========================================
Route::match(['get', 'post'], '/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
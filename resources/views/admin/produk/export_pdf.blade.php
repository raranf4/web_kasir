<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan_Stok_SweetBakery_{{ date('dMY') }}</title>
    <style>
        /* Desain Khusus Cetak Kertas A4 Kebawah */
        body { 
            font-family: 'Helvetica Neue', Arial, sans-serif; 
            color: #2d1b10; 
            background: #fff; 
            padding: 10px 20px;
            margin: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        /* Kop Surat Toko Kue */
        .header-nota { 
            text-align: center; 
            margin-bottom: 25px; 
            border-bottom: 2px solid #2d1b10; 
            padding-bottom: 12px; 
        }
        .header-nota h2 { 
            margin: 0; 
            font-size: 22px;
            font-weight: 800; 
            letter-spacing: 1px; 
            color: #2d1b10;
        }
        .header-nota p { 
            margin: 4px 0 0 0; 
            color: #7d6b5e; 
            font-size: 12px; 
            font-weight: 500;
        }

        /* Desain Tabel Ringkas Tanpa Deskripsi */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        th, td { 
            border: 1px solid #ebdcd0; 
            padding: 10px 12px; 
            font-size: 13px; 
        }
        th { 
            background-color: #fdfbf7 !important; 
            font-weight: 700; 
            color: #2d1b10; 
            text-transform: uppercase;
            font-size: 11.5px;
            letter-spacing: 0.5px;
        }
        tr:nth-child(even) {
            background-color: #fdfdfd;
        }
        
        /* Penataan Aligment Kolom */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        
        /* Badge Kategori Mini */
        .badge-kategori {
            background-color: #f7f3ed !important;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }
    </style>
</head>
<body>

    <div class="header-nota">
        <h2>SWEETBAKERY LAPORAN DATA INVENTORI</h2>
        <p>Dicetak otomatis melalui sistem administrasi pada: {{ date('d-m-Y H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="35" class="text-center">No</th>
                <th>Nama Varian Produk Kue</th>
                <th width="150">Kelompok Kategori</th>
                <th width="120" class="text-right">Harga Jual</th>
                <th width="90" class="text-center">Sisa Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produks as $index => $p)
            <tr>
                <td class="text-center text-muted">{{ $index + 1 }}</td>
                <td class="fw-bold" style="color: #2d1b10;">{{ $p->nama_produk }}</td>
                <td>
                    <span class="badge-kategori">
                        {{ $p->kategori->nama_kategori ?? 'Roti' }}
                    </span>
                </td>
                <td class="text-right fw-bold">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                <td class="text-center fw-bold" style="{{ $p->stok <= 15 ? 'color: #e63946;' : '' }}">
                    {{ $p->stok }} Pcs
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 30px; color: #7d6b5e;">
                    Tidak ada data produk kue yang tersedia di dalam database etalase.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        window.onload = function() {
            // 1. Jalankan perintah cetak jendela browser bawaan
            window.print();
        }

        // 2. Kunci Utama: Deteksi ketika user menutup jendela print (baik klik Save maupun Cancel)
        window.onafterprint = function() {
            // Langsung lempar balik dengan aman ke rute halaman data produk admin
            window.location.href = "{{ route('admin.produk.index') }}";
        };

        // Cadangan deteksi jika versi browser tertentu tidak mendukung onafterprint dengan sempurna
        setTimeout(function () {
            // Jika dalam 10 menit tab masih terbuka pasca render, kita balikkan ke dashboard produk
            document.body.onfocus = function () { 
                window.location.href = "{{ route('admin.produk.index') }}"; 
            };
        }, 500);
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Kedai SweetBakery - Cetak Resmi</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A4;
            margin: 15mm 12mm;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            color: #2d1b10;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .header-kedai {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px dashed #d4a373;
            padding-bottom: 15px;
        }
        .header-kedai h2 {
            margin: 0;
            font-weight: 800;
            font-size: 24px;
            letter-spacing: 1px;
            color: #2d1b10;
        }
        .header-kedai p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #8c7e74;
            font-style: italic;
        }
        .menu-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 12px;
        }
        .menu-card-cell {
            width: 25%;
            vertical-align: top;
            background-color: #ffffff;
            border: 1px solid #efeae4;
            border-radius: 12px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }
        .photo-container {
            width: 100%;
            height: 110px;
            border-radius: 8px;
            background-color: #fcfaf7;
            overflow: hidden;
            margin-bottom: 8px;
            border: 1px solid #f2ede7;
            position: relative;
        }
        .product-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .no-photo-text {
            font-size: 10px;
            color: #c4b9b0;
            font-weight: 600;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-transform: uppercase;
        }
        .badge-kategori {
            display: inline-block;
            font-size: 9px;
            font-weight: 700;
            color: #d4a373;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .product-name {
            font-size: 12px;
            font-weight: 700;
            color: #2d1b10;
            margin: 0 0 6px 0;
            line-height: 1.3;
            height: 32px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .product-price {
            font-size: 13px;
            font-weight: 800;
            color: #198754;
            margin: 0;
        }
    </style>
</head>
<body>

    <div class="header-kedai">
        <h2>SWEETBAKERY MENU</h2>
        <p>— Freshly Baked Daily Finest Menu List —</p>
    </div>

    <table class="menu-table">
        @php $counter = 0; @endphp
        @foreach(\App\Models\Produk::with('kategori')->get() as $p)
            @if($counter % 4 == 0)
                <tr>
            @endif

            <td class="menu-card-cell">
                <div class="photo-container">
                    @php
                        $pathFoto = $p->gambar ?? $p->foto_produk ?? $p->foto;
                    @endphp

                    @if($pathFoto)
                        <img src="{{ filter_var($pathFoto, FILTER_VALIDATE_URL) ? $pathFoto : asset($pathFoto) }}" class="product-photo" alt="Menu">
                    @else
                        <div class="no-photo-text">🧁 No Photo</div>
                    @endif
                </div>

                <span class="badge-kategori">{{ $p->kategori->nama_kategori ?? $p->kategori->kategori ?? 'Bakery' }}</span>
                <p class="product-name">{{ $p->nama_produk ?? $p->nama ?? 'Varian Kue' }}</p>
                <p class="product-price">Rp {{ number_format($p->harga ?? 0, 0, ',', '.') }}</p>
            </td>

            @php $counter++; @endphp
            @if($counter % 4 == 0)
                </tr>
            @endif
        @endforeach

        @if($counter % 4 != 0)
            @while($counter % 4 != 0)
                <td style="width: 25%; border: none; background: none;"></td>
                @php $counter++; @endphp
            @endwhile
            </tr>
        @endif
    </table>

    <script>
        window.onload = function() {
            window.print();
        };

        // FIX ANTI-LOCK: Jika user menekan Cancel atau Save, halaman otomatis melompat kembali ke katalog etalase dengan mulus
        window.onafterprint = function() {
            window.location.href = "{{ route('user.produk.index') }}";
        };
    </script>

</body>
</html>
<table border="1">
    <thead>
        <tr style="background-color: #f7f3ed; font-weight: bold;">
            <th>No</th>
            <th>Nama Produk Kue</th>
            <th>Kelompok Kategori</th>
            <th>Harga Jual</th>
            <th>Sisa Stok</th>
            <th>Deskripsi Produk</th>
        </tr>
    </thead>
    <tbody>
        @foreach($produks as $index => $p)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td style="font-weight: bold;">{{ $p->nama_produk }}</td>
            <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
            <td>{{ $p->harga }}</td>
            <td>{{ $p->stok }}</td>
            <td>{{ $p->deskripsi ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
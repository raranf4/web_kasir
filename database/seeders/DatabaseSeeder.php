<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Roles
        $adminRole = Role::create(['nama_role' => 'admin']);
        $userRole = Role::create(['nama_role' => 'user']);

        // 2. Seed Users
        User::create([
            'role_id' => $adminRole->id,
            'name' => 'Owner Bakery (Admin)',
            'email' => 'admin@bakery.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'role_id' => $userRole->id,
            'name' => 'Izuma',
            'email' => 'kasir1@bakery.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'role_id' => $userRole->id,
            'name' => 'Rzee',
            'email' => 'kasir2@bakery.com',
            'password' => Hash::make('password123'),
        ]);

        // 3. Seed Kategori
        $roti = Kategori::create(['nama_kategori' => 'Roti & Bun']);
        $cake = Kategori::create(['nama_kategori' => 'Cake & Pastry']);
        $cookies = Kategori::create(['nama_kategori' => 'Kue Kering']);

        // 4. Seed Produk (Murni tanpa deskripsi dan gambar, nanti di-edit via web)
        Produk::create(['nama_produk' => 'Roti Sobek Cokelat', 'harga' => 18000, 'stok' => 15, 'kategori_id' => $roti->id, 'deskripsi' => null, 'gambar' => null]);
        Produk::create(['nama_produk' => 'Croissant Original', 'harga' => 22000, 'stok' => 12, 'kategori_id' => $roti->id, 'deskripsi' => null, 'gambar' => null]);
        Produk::create(['nama_produk' => 'Roti Sisir Mentega', 'harga' => 14000, 'stok' => 25, 'kategori_id' => $roti->id, 'deskripsi' => null, 'gambar' => null]);
        Produk::create(['nama_produk' => 'Roti Abon Sapi', 'harga' => 16500, 'stok' => 20, 'kategori_id' => $roti->id, 'deskripsi' => null, 'gambar' => null]);
        
        Produk::create(['nama_produk' => 'Fudge Brownies Slice', 'harga' => 25000, 'stok' => 10, 'kategori_id' => $cake->id, 'deskripsi' => null, 'gambar' => null]);
        Produk::create(['nama_produk' => 'Strawberry Cheese Cake', 'harga' => 35000, 'stok' => 8, 'kategori_id' => $cake->id, 'deskripsi' => null, 'gambar' => null]);
        Produk::create(['nama_produk' => 'Choux Pastry (Kue Soes)', 'harga' => 8000, 'stok' => 30, 'kategori_id' => $cake->id, 'deskripsi' => null, 'gambar' => null]);
        
        Produk::create(['nama_produk' => 'Nastar Keju Premium (Toples)', 'harga' => 85000, 'stok' => 15, 'kategori_id' => $cookies->id, 'deskripsi' => null, 'gambar' => null]);
        Produk::create(['nama_produk' => 'Kastengel Garing (Toples)', 'harga' => 90000, 'stok' => 10, 'kategori_id' => $cookies->id, 'deskripsi' => null, 'gambar' => null]);
        Produk::create(['nama_produk' => 'Choco Chip Cookies', 'harga' => 45000, 'stok' => 18, 'kategori_id' => $cookies->id, 'deskripsi' => null, 'gambar' => null]);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    // FIX TOTAL: Mematikan proteksi laravel (Sistem bebas memasukkan data ke kolom mana saja)
    protected $guarded = [];

    public function produks()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    // Supaya semua kolom bisa diisi massal kecuali ID
    protected $guarded = ['id'];

    // TAMBAHKAN BARIS INI UNTUK MEMATIKAN UPDATED_AT
    const UPDATED_AT = null;

    // Relasi: 1 Kategori punya BANYAK Produk
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Supaya semua kolom bisa diisi massal kecuali ID
    protected $guarded = ['id'];

    // Relasi: 1 Produk ini MILIK 1 Kategori
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
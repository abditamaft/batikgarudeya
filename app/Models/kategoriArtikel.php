<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategoriArtikel extends Model
{
    protected $table = 'article_categories';
    protected $fillable = [
        'name',
        'slug',
    ];
    public function articles()
    {
        return $this->hasMany(artikel::class, 'category_id');
    }
}

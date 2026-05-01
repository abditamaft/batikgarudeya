<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class artikel extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'admin_id',
        'category_id',
        'title',
        'slug',
        'thumbnail',
        'content',
        'views',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function category()
    {
        return $this->belongsTo(kategoriArtikel::class, 'category_id');
    }
}

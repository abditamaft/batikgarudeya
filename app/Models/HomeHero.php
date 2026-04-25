<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeHero extends Model
{
    protected $table = 'home_hero'; // Kunci perbaikannya ada di sini
    protected $guarded = ['id'];
    public $timestamps = false;
}

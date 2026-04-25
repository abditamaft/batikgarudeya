<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeAbout extends Model
{
    protected $table = 'home_about'; // Kunci perbaikannya ada di sini
    protected $guarded = ['id'];
    public $timestamps = false;
}

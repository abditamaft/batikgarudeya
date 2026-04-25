<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins'; // Arahkan ke tabel admins
    protected $guarded = ['id'];
    protected $hidden = ['password'];
}
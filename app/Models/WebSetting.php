<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    protected $table = 'web_settings';
    protected $guarded = ['id'];
    public $timestamps = false; // Matikan timestamps default agar tidak error
}
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $table = 'company_profiles';
    protected $guarded = ['id'];
    public $timestamps = false; // Matikan karena tabel kita tidak ada created_at
}
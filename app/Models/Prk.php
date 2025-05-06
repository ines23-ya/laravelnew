<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prk extends Model
{
    use HasFactory;

    // Tentukan kolom-kolom yang bisa diisi secara massal (Mass Assignment)
    protected $fillable = ['nama']; // Kolom 'nama' yang dapat diisi

    // Relasi dengan model lain, misalnya Prk memiliki banyak Fungsi
    public function funksis()
    {
        return $this->hasMany(Fungsi::class); // Relasi 'hasMany' dengan model Fungsi
    }
}

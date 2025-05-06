<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fungsi extends Model
{
    use HasFactory;

    // Tentukan kolom-kolom yang bisa diisi secara massal (Mass Assignment)
    protected $fillable = ['nama']; // Sama seperti Unsur, hanya ada kolom 'nama'

    // Relasi dengan model lain, misalnya Fungsi memiliki banyak Renev
    public function renevs()
    {
        return $this->hasMany(Renev::class); // Relasi 'hasMany' dengan model Renev
    }
}

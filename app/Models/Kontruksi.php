<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontruksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pekerjaan', 'no_kontrak', 'tanggal_kontrak', 'nilai', 'progres', 'keterangan', 'bp_lkp', 'bp_st', 'bp_pp'
    ];

    // Relasi dengan Pengadaan (jika diperlukan)
    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class, 'no_kontrak', 'no_kontrak');
    }
    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'no_kontrak', 'no_kontrak');
    }
    public function renev()
{
    return $this->belongsTo(Renev::class, 'no_kontrak', 'no_kontrak');
}

}

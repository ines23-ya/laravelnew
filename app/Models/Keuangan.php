<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $fillable = [
        'no_prk', 'no_kontrak', 'judul_kontrak', 'pekerjaan', 'nilai', 'jangka_waktu', 
        'progres', 'bp_lkp', 'bp_st', 'bp_pp', 'keterangan'
    ];

    // Relationship to Renev
    public function renev()
    {
        return $this->belongsTo(Renev::class, 'no_prk', 'no_prk');
    }

    // Relationship to Pengadaan
    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class, 'no_kontrak', 'no_kontrak');
    }

    // Relationship to Kontruksi
    public function kontruksi()
    {
        return $this->belongsTo(Kontruksi::class, 'no_kontrak', 'no_kontrak');
    }
}

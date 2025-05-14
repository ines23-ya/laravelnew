<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'unsur_id',
        'fungsi_id',
        'renev_id', 
        'no_kontrak',
        'judul_kontrak',
        'tanggal_kontrak',
        'jangka_mulai',
        'jangka_akhir',
        'vendor_pelaksana',
        'nilai_kontrak',
        'dokumen',
        'dokumen_name',
        'jangka_waktu',
    ];

    // Ensure that these date fields are treated as Carbon instances
    protected $dates = [
        'tanggal_kontrak',
        'jangka_mulai',
        'jangka_akhir',
    ];

    public function unsur()
    {
        return $this->belongsTo(Unsur::class, 'unsur_id');
    }

    public function fungsi()
    {
        return $this->belongsTo(Fungsi::class, 'fungsi_id');
    }

   
     public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'no_kontrak', 'no_kontrak');
    }
    public function kontruksi()
    {
        return $this->hasMany(Kontruksi::class, 'no_kontrak', 'no_kontrak');
    }
    public function renev()
{
    return $this->belongsTo(Renev::class, 'no_kontrak', 'no_kontrak');
}

}

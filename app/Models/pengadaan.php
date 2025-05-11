<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengadaan extends Model
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

    public function renev()
    {
        return $this->belongsTo(Renev::class, 'renev_id');
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renev extends Model
{
    use HasFactory;

    protected $fillable = [
        'unsur_id',
        'fungsi_id',
        'no_prk', // This is just a string column, not a relationship
        'no_skko',
        'pekerjaan',
        'satuan',
        'volume',
        'total_material',
        'total_jasa',
        'jumlah_pagu',
    ];

    public function unsur()
    {
        return $this->belongsTo(Unsur::class);
    }

    public function fungsi()
    {
        return $this->belongsTo(Fungsi::class);
    }

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'no_prk', 'no_prk');
    }

  public function pengadaan()
{
    return $this->hasOne(Pengadaan::class, 'no_kontrak', 'no_kontrak');  // Relasi satu-ke-satu dengan Pengadaan
}

public function kontruksi()
{
    return $this->hasOne(Kontruksi::class, 'no_kontrak', 'no_kontrak');  // Relasi satu-ke-satu dengan Kontruksi
}


}

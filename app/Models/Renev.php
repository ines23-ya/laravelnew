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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fungsi extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'prk_id'];

    public function renevs()
    {
        return $this->hasMany(Renev::class);
    }

    public function prk()
    {
        return $this->belongsTo(Prk::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prk extends Model
{
    use HasFactory;

    protected $fillable = ['nomor'];


    public function fungsis()
    {
        return $this->hasMany(Fungsi::class);
    }
}

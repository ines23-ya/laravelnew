<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unsur extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function renevs()
    {
        return $this->hasMany(Renev::class);
    }
}

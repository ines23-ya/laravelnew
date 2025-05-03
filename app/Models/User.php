<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false; // Menonaktifkan created_at & updated_at

    protected $fillable = [
        'nik', 'username', 'email', 'bidang', 'no_hp', 'password'
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Override agar login menggunakan username, bukan email.
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }
}

<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_pelanggan';
    protected $primaryKey = 'id_pelanggan';
    public $timestamps = false;

    protected $fillable = [
        'nama_pelanggan', 'telp_pelanggan', 'email_pelanggan', 'password_pelanggan', 'foto_pelanggan', 'role_pelanggan', 'status_pelanggan'
    ];

    protected $hidden = [
        'password_pelanggan',
    ];
}

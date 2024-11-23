<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pegawai extends Authenticatable
{
    use HasFactory;

    protected $table = 'tb_pegawai';
    protected $primaryKey = 'id_pegawai';
    public $timestamps = true;

    protected $fillable = [
        'id_bengkel',
        'id_pelanggan',
        'nama_pegawai',
        'telp_pegawai',
        'email_pegawai',
        'foto_pegawai',
        'password_pegawai',
        'role',
        'delete_pegawai',
    ];

    protected $hidden = [
        'password_pegawai',
    ];

    public function getAuthPassword()
    {
        return $this->password_pegawai;
    }

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id_bengkel', 'id_bengkel');
    }
}

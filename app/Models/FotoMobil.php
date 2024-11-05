<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoMobil extends Model
{
    use HasFactory;

    protected $table = 'tb_foto_mobil';
    protected $primaryKey = 'id_foto_mobil';
    public $timestamps = false;

    protected $fillable = [
        'id_mobil', 'id_pelanggan', 'file_foto_mobil',
        'file_foto_mobil_2', 'file_foto_mobil_3',
        'file_foto_mobil_4', 'file_foto_mobil_5',
        'create_file_foto_mobil', 'delete_file_foto_mobil'
    ];

    public function mobil()
    {
        return $this->belongsTo(UsedCar::class, 'id_mobil', 'id_mobil');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
}

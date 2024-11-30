<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesananService extends Model
{
    use HasFactory;

    protected $table = 'tb_pesanan_service'; // Nama tabel
    protected $primaryKey = 'id_pesanan'; // Primary key
    public $timestamps = true; // Aktifkan timestamps (created_at, updated_at)

    // Kolom yang dapat diisi
    protected $fillable = [
        'id_pelanggan',
        'id_bengkel',
        'nama_pemesan',
        'tgl_pesanan',
        'nama_service',
        'status',
    ];
}

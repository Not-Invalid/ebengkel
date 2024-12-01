<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOnline extends Model
{
    use HasFactory;

    protected $table = 't_order_online'; // Nama tabel
    protected $primaryKey = 'id'; // Primary key
    public $timestamps = false; // Jika tidak menggunakan kolom created_at dan updated_at

    // Kolom yang dapat diisi
    protected $fillable = [
        'id_outlet',
        'id_pelanggan',
        'tanggal',
        'total_qty',
        'total_harga',
        'status_pengiriman',
        'kurir',
        'biaya_pengiriman',
        'grand_total',
        'atas_nama',
        'alamat_pengiriman',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',
        'kode_pos',
        'no_telp',
        'jenis_pengiriman',
        'no_resi',
        'tanggal_kirim',
        'tanggal_diterima',
        'status_order',
        'is_delete',
    ];

    // Relasi jika diperlukan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
}

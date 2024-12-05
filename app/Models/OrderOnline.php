<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOnline extends Model
{
    use HasFactory;
    protected $table = 't_order_online';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id_bengkel',
        'id_pelanggan',
        'id_produk',
        'id_spare_part',
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
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }
    public function sparepart()
    {
        return $this->belongsTo(SpareParts::class, 'id_spare_part');
    }
}

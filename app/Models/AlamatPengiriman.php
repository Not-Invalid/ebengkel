<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlamatPengiriman extends Model
{
    use HasFactory;

    protected $table = 'tb_alamat_pengiriman';

    protected $primaryKey = 'id_alamat_pengiriman';

    public $incrementing = true;

    protected $fillable = [
        'id_pelanggan',
        'nama_penerima',
        'telp_penerima',
        'lokasi_alamat_pengiriman',
        'kodepos_alamat_pengiriman',
        'lat_alamat_pengiriman',
        'long_alamat_pengiriman',
        'status_alamat_pengiriman',
        'provinsi_id',
        'kota_id',
        'kecamatan_id',
        'delete_alamat_pengiriman',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
}

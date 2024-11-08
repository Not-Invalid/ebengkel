<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedCar extends Model
{
    use HasFactory;

    protected $table = 'tb_mobil';
    protected $primaryKey = 'id_mobil';
    public $timestamps = false;

    protected $fillable = [
        'id_pelanggan',
        'nama_mobil',
        'merk_mobil',
        'harga_mobil',
        'tahun_mobil',
        'plat_nomor_mobil',
        'nomor_rangka_mobil',
        'nomor_mesin_mobil',
        'kapasitas_mesin_mobil',
        'bahan_bakar_mobil',
        'jenis_transmisi_mobil',
        'km_mobil',
        'bulan_pajak_mobil',
        'tahun_pajak_mobil',
        'terakhir_service_mobil',
        'terakhir_pajak_mobil',
        'keterangan_mobil',
        'lokasi_mobil',
        'kodepos_mobil',
        'lat_mobil',
        'long_mobil',
        'approv_mobil',
        'status_mobil',
        'sold_out_mobil',
        'create_date',
        'delete_mobil'
    ];

    public function fotos()
    {
        return $this->hasOne(FotoMobil::class, 'id_mobil', 'id_mobil');
    }

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'id_pelanggan');
    }
}

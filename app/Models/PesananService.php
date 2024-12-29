<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananService extends Model
{
    use HasFactory;
    protected $table = 'tb_pesanan_service';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = true;
    protected $fillable = [
        'id_pelanggan',
        'id_bengkel',
        'id_pegawai',
        'telp_pelanggan',
        'nama_pemesan',
        'tgl_pesanan',
        'nama_services',
        'jumlah_services_online',
        'jumlah_services_offline',
        'status',
        'total_pesanan',
    ];
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'nama_services', 'id_services');
    }
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
}

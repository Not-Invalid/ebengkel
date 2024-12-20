<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'tb_services';
    protected $primaryKey = 'id_services';
    public $incrementing = true;
    protected $keyType = 'integer';
    public $timestamps = false;
    protected $fillable = [
        'id_bengkel',
        'nama_services',
        'keterangan_services',
        'harga_services',
        'foto_services',
        'jumlah_services_online',
        'jumlah_services_offline',
        'delete_services',
    ];

    /**
     *
     */
    public function bengkel()
    {
        return $this->belongsTo(Bengkel::class, 'id_bengkel');
    }
    // In Service.php model
    public function pesananServices()
    {
        return $this->hasMany(PesananService::class, 'nama_services', 'id_services');
    }

}

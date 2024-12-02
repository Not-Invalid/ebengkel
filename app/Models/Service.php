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
        'jumlah_services',
        'delete_services',
    ];

    /**
     * 
     */
    public function bengkel()
    {
        return $this->belongsTo(Bengkel::class, 'id_bengkel');
    }
}

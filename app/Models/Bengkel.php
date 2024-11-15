<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bengkel extends Model
{
    use HasFactory;

    protected $table = 'tb_bengkel';
    protected $primaryKey = 'id_bengkel';
    public $timestamps = false;
    public $incrementing = true;
/**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_pelanggan',
        'foto_cover_bengkel',
        'foto_bengkel',
        'nama_bengkel',
        'tagline_bengkel',
        'alamat_bengkel',
        'gmaps',
        'open_day',
        'close_day',
        'open_time',
        'close_time',
        'service_available',
        'payment',
        'whatsapp',
        'instagram',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'service_available' => 'array', 
        'payment' => 'array',           
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
}

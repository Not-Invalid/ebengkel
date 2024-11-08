<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'tb_event';
    protected $primaryKey = 'id_event';
    public $incrementing = true;
    protected $fillable = [
        'nama_event',
        'event_start_date',
        'event_end_date',
        'deskripsi',
        'alamat_event',
        'image_cover',
        'lokasi',
        'tipe_harga',
        'harga',
        'delete_event',
    ];

    protected $casts = [
        'agenda_acara' => 'array',
        'bintang_tamu' => 'array',
    ];

}



<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewWorkshop extends Model
{
    use HasFactory;

    protected $table = 'tb_ulasan'; // Define the table name

    protected $fillable = [
        'id_pelanggan',
        'id_bengkel',
        'rating',
        'komentar',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    // Relasi ke model Bengkel
    public function bengkel()
    {
        return $this->belongsTo(Bengkel::class, 'id_bengkel', 'id_bengkel');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpareParts extends Model
{
    use HasFactory;
    protected $table = 'tb_spare_part';
    protected $primaryKey = 'id_spare_part';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_bengkel',
        'id_jenis_spare_part',
        'id_kategori_spare_part',
        'kualitas_spare_part',
        'merk_spare_part',
        'nama_spare_part',
        'harga_spare_part',
        'keterangan_spare_part',
        'foto_spare_part',
        'stok_spare_part',
        'delete_spare_part',
    ];

    public function kategoriSparePart()
    {
        return $this->belongsTo(KategoriSparePart::class, 'id_kategori_spare_part', 'id_kategori_spare_part');
    }
    public function bengkel()
    {
        return $this->belongsTo(Bengkel::class, 'id_bengkel', 'id_bengkel');
    }
}

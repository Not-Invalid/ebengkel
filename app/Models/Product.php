<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'tb_produk';
    protected $primaryKey = 'id_produk';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'id_bengkel',
        'id_kategori_spare_part',
        'kualitas_produk',
        'merk_produk',
        'nama_produk',
        'harga_produk',
        'keterangan_produk',
        'foto_produk',
        'stok_produk',
        'create_produk',
        'delete_produk',
    ];

    public function kategoriProduk()
    {
        return $this->belongsTo(KategoriSparePart::class, 'id_kategori_produk', 'id_kategori_spare_part');
    }

    public function kategoriProduct()
    {
        return $this->belongsTo(KategoriSparePart::class, 'id_kategori_spare_part', 'id_kategori_spare_part');
    }

    public function bengkel()
    {
        return $this->belongsTo(Bengkel::class, 'id_bengkel', 'id_bengkel');
    }
}

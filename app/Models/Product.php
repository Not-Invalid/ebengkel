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
    protected $fillable = [
        'id_bengkel',
        'id_kategori_produk',
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
}

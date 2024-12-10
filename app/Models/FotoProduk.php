<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoProduk extends Model
{
    use HasFactory;

    protected $table = 'tb_foto_produk';
    protected $primaryKey = 'id_foto_produk';
    public $timestamps = true;

    protected $fillable = [
        'id_produk',
        'file_foto_produk_1',
        'file_foto_produk_2',
        'file_foto_produk_3',
        'file_foto_produk_4',
        'file_foto_produk_5',
        'create_file_foto_produk',
        'delete_file_foto_produk',
    ];

    protected $dates = [
        'create_file_foto_produk',
        'created_at',
        'updated_at',
    ];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id_produk');
    }
}

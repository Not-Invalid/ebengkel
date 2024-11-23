<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pelanggan;
use App\Models\Product;

class Cart extends Model
{
    protected $table = 'tb_cart';

    protected $fillable = ['id_pelanggan', 'id_produk', 'quantity', 'total_price'];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
}

<?php

namespace App\Models;

use App\Models\Pelanggan;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'tb_cart';

    protected $fillable = ['id_pelanggan', 'id_produk', 'id_spare_part', 'quantity', 'total_price'];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function sparepart()
    {
        return $this->belongsTo(SpareParts::class, 'id_spare_part');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
}

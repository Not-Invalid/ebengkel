<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 't_order_item';
    protected $primaryKey = 'id_order_item';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_order',
        'id_bengkel',
        'id_produk',
        'id_spare_part',
        'tanggal',
        'warna',
        'size',
        'qty',
        'harga_beli',
        'harga',
        'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id_produk');
    }

    public function sparePart()
    {
        return $this->belongsTo(SpareParts::class, 'id_spare_part', 'id_spare_part');
    }
}

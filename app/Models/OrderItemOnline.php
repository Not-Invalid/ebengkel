<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemOnline extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan penamaan konvensional
    protected $table = 't_order_item_online';

    // Tentukan kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'id_order_online',
        'id_bengkel',
        'id_produk',
        'id_spare_part',
        'tanggal',
        'qty',
        'harga_beli',
        'harga',
        'subtotal'
    ];

    // Relasi dengan tabel OrderOnline (Order Utama)
    public function orderOnline()
    {
        return $this->belongsTo(OrderOnline::class, 'id_order_online');
    }

    // Relasi dengan tabel Bengkel (Outlet)
    public function bengkel()
    {
        return $this->belongsTo(Bengkel::class, 'id_bengkel', 'id_bengkel');
    }

    // Relasi dengan tabel Produk (Barang)
    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id_produk');
    }

    // Relasi dengan tabel SparePart
    public function sparepart()
    {
        return $this->belongsTo(SpareParts::class, 'id_spare_part', 'id_spare_part');
    }

    // Menghitung subtotal berdasarkan harga dan jumlah
    public function calculateSubtotal()
    {
        return $this->qty * $this->harga;
    }
}

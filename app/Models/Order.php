<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 't_order';
    protected $primaryKey = 'id_order';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'kode_order', // Tambahkan kode order
        'nama_customer',
        'id_bengkel',
        'tanggal',
        'tipe',
        'jenis_pembayaran',
        'no_kartu',
        'harga',
        'diskon',
        'ppn',
        'total_harga',
        'total_qty',
        'nominal_bayar',
        'kembali',
        'input_by',
        'is_delete',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->kode_order = strtoupper(uniqid('ORD'));
        });
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'id_order', 'id_order');
    }

    public function bengkel()
    {
        return $this->belongsTo(Bengkel::class, 'id_bengkel');
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

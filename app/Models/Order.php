<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 't_order';

    // Menentukan kolom yang bisa diisi secara massal
    protected $fillable = [
        'id_outlet',
        'id_customer',
        'id_voucher',
        'tanggal',
        'nama',
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
        'is_delete'
    ];

    // Menentukan apakah tabel menggunakan timestamps
    public $timestamps = true; // Atur false jika tabel tidak memiliki kolom created_at dan updated_at

    // Relasi dengan model lain (misalnya jika pesanan memiliki beberapa item)
    // public function orderItems()
    // {
    //     return $this->hasMany(OrderItem::class, 'id_order');
    // }
}

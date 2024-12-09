<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 't_order';
    protected $fillable = [
        'id_order',
        'nama_customer',
        'id_bengkel',
        'id_voucher',
        'tanggal',
        'id_produk',
        'id_spare_part',
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
    public $timestamps = true;
}

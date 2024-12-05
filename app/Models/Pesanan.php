<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 't_order';
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
    public $timestamps = true;
}

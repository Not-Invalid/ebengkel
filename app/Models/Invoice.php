<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 't_invoice';

    protected $fillable = [
        'id_pelanggan',
        'id_order',
        'status_invoice',
        'jatuh_tempo',
        'tanggal_invoice',
        'tanggal_bayar',
        'nama_rekening',
        'no_rekening',
        'jenis_pembayaran',
        'bank_tujuan',
        'note',
        'tanggal_transfer',
        'nominal_transfer',
        'bukti_bayar',
        'is_delete',
    ];

    public function order()
    {
        return $this->belongsTo(OrderOnline::class, 'id_order', 'order_id');
    }


    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id');
    }
}

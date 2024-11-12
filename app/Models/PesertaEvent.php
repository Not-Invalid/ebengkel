<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaEvent extends Model
{
    protected $table = 'tb_peserta_event';
    protected $primaryKey = 'id_peserta';

    protected $fillable = [
        'event_id',
        'nama_peserta',
        'email',
        'no_telepon',
        'amount_paid',
        'payment_status',
        'payment_date',
    ];
}

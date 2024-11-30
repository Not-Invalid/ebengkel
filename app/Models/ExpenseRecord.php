<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseRecord extends Model
{
    protected $table = 't_pengeluaran';


    protected $fillable = [
        'id_jenis_pengeluaran',
        'id_bengkel',
        'keterangan',
        'tanggal',
        'nominal',
        'input_by',
        'is_delete'
    ];

    protected $primaryKey = 'id_pengeluaran';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    /**
     * Relasi: Setiap pengeluaran terkait dengan jenis pengeluaran
     */
    public function jenisPengeluaran()
    {
        return $this->belongsTo(JenisPengeluaran::class, 'id_jenis_pengeluaran', 'id_jenis_pengeluaran');
    }

}

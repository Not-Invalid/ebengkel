<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPengeluaran extends Model
{
    use HasFactory;

    protected $table = 'm_jenis_pengeluaran';

    protected $fillable = [
        'nama_jenis_pengeluaran',
        'keterangan',
        'is_delete'
    ];

    protected $primaryKey = 'id_jenis_pengeluaran';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    /**
     * Relasi: JenisPengeluaran memiliki banyak pengeluaran
     */
    public function pengeluaran()
    {
        return $this->hasMany(ExpenseRecord::class, 'id_jenis_pengeluaran', 'id_jenis_pengeluaran');
    }
}

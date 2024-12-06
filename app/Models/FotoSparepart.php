<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoSparepart extends Model
{
    use HasFactory;

    protected $table = 'tb_foto_spare_part';

    protected $fillable = [
        'id_spare_part',
        'file_foto_spare_part_1',
        'file_foto_spare_part_2',
        'file_foto_spare_part_3',
        'file_foto_spare_part_4',
        'file_foto_spare_part_5',
        'create_file_foto_spare_part',
        'delete_file_foto_spare_part',
    ];

    protected $dates = [
        'create_file_foto_spare_part',
        'created_at',
        'updated_at',
    ];

    public function sparepart()
    {
        return $this->belongsTo(SpareParts::class, 'id_spare_part', 'id_spare_part');
    }
}

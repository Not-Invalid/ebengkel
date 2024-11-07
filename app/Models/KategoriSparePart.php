<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriSparePart extends Model
{
    protected $primaryKey = 'id_kategori_spare_part';
    protected $table = 'tb_kategori_spare_part';

    protected $fillable = [
        'nama_kategori_spare_part', 'created_date', 'updated_date', 'deleted_kategori_spare_part'
    ];

    public $timestamps = false;
}

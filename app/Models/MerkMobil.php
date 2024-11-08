<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerkMobil extends Model
{
    protected $table = 'tb_merk_mobil';

    protected $fillable = ['nama_merk'];
}

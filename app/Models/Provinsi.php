<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Provinsi extends Model
{
    use HasFactory;
    protected $table = 'm_provinsi';
    protected $primaryKey = 'province_id';
    protected $fillable = ['province_name'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kota extends Model
{
    use HasFactory;

    protected $table = 'm_kota';
    protected $primaryKey = 'city_id';
    protected $fillable = ['province_id', 'city_name', 'postal_code'];

    public function province()
    {
        return $this->belongsTo(Provinsi::class, 'province_id');
    }

}

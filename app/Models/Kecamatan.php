<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'm_kecamatan';
    protected $primaryKey = 'subdistrict_id';
    protected $fillable = ['city_id', 'subdistrict_name'];

    public function city()
    {
        return $this->belongsTo(Kota::class, 'city_id');
    }
}

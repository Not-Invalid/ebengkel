<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportCategory extends Model
{
    use HasFactory;

    protected $table = 'tb_support_categories';
    protected $fillable = ['nama_category', 'icon'];

    public function details()
    {
        return $this->hasMany(SupportInfo::class);
    }
}

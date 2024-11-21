<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBlog extends Model
{
    protected $table = 'tb_kategori_blog';

    protected $fillable = [
        'nama_kategori'
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'id_kategori');
    }
}

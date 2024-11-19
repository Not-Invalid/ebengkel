<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'tb_blog';

    protected $fillable = [
        'judul', 'konten', 'penulis', 'tanggal_post', 'id_kategori'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBlog::class, 'id_kategori');
    }
}

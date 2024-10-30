<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Message extends Model
{
    protected $table = 'tb_messages';
    use HasFactory;
    protected $fillable = ['nama', 'email', 'telepon', 'pesan'];
}

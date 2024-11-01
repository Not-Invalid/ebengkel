<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportInfo extends Model
{
    use HasFactory;

    protected $table = 'tb_support_info';
    protected $fillable = ['support_category_id', 'question', 'answer'];

    public function category()
    {
        return $this->belongsTo(SupportCategory::class);
    }
}


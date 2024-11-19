<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'm_menu';

    protected $fillable = [
        'parent_id_1',
        'parent_id_2',
        'parent_id_3',
        'menu_position',
        'nama_menu',
        'link_menu',
        'icon_menu',
        'menu_type',
        'input_by',
        'input_date',
        'update_by',
        'update_date',
        'delete_by',
        'delete_date',
        'is_delete',
    ];

    protected $dates = [
        'input_date',
        'update_date',
        'delete_date',
    ];
}

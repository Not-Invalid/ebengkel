<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;

    protected $table = 'tb_management_stock_opname';  // Nama tabel
    protected $primaryKey = 'id_opname';   // Primary key

    protected $fillable = [
        'id_bengkel',
        'id_produk',
        'stock_recorded',
        'stock_actual',
        'difference',
        'description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}

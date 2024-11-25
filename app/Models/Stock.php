<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'tb_management_stock';
    protected $primaryKey = 'id_stock';
    public $timestamps = false;

    protected $fillable = [
        'id_bengkel',
        'id_produk',  // Use 'id_produk' as the field name
        'quantity',
        'description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id_produk'); // Match the actual field name
    }

    public function bengkel()
    {
        return $this->belongsTo(Bengkel::class, 'id_bengkel', 'id_bengkel');
    }
    
}

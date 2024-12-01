<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;

    protected $table = 'tb_management_stock_opname';
    protected $primaryKey = 'id_opname';
    public $timestamps = false;

    protected $fillable = [
        'id_bengkel',
        'id_produk',
        'id_spare_part',
        'actual_quantity',
        'description',
        'id_pegawai',
        'type'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id_produk');
    }

    public function sparePart()
    {
        return $this->belongsTo(SpareParts::class, 'id_spare_part', 'id_spare_part');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    public function bengkel()
    {
        return $this->belongsTo(Bengkel::class, 'id_bengkel', 'id_bengkel');
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInbound extends Model
{
    use HasFactory;

    protected $table = 'tb_management_stock_inbound';
    protected $primaryKey = 'id_stock';
    public $timestamps = false;

    protected $fillable = [
        'id_bengkel',
        'id_produk',  // Use 'id_produk' as the field name
        'quantity',
        'description',
        'id_pegawai',  // Ensure this is fillable
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id_produk'); // Match the actual field name
    }
    public function sparePart()
    {
        return $this->belongsTo(SpareParts::class, 'id_spare_part'); // Adjust as needed
    }
    // In StockInbound model
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
    public function bengkel()
    {
        return $this->belongsTo(Bengkel::class, 'id_bengkel', 'id_bengkel');
    }
    
}

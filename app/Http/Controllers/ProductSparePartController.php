<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\FotoProduk;
use App\Models\FotoSparepart;
use App\Models\KategoriSparePart;
use App\Models\Product;
use App\Models\SpareParts;
use App\Models\OrderItem;
use App\Models\OrderItemOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductSparePartController extends Controller
{

    public function index(Request $request)
    {
        $category = $request->input('category', 'all');

        $querySparepart = SpareParts::where('delete_spare_part', 'N')->with('bengkel', 'fotoSparepart');
        $queryProduct = Product::where('delete_produk', 'N')->with('bengkel', 'fotoProduk');

        if ($request->has('search')) {
            $search = $request->input('search');
            $querySparepart->where('nama_spare_part', 'LIKE', '%' . $search . '%');
            $queryProduct->where('nama_produk', 'LIKE', '%' . $search . '%');
        }

        if ($category === 'product') {
            $product = $queryProduct->paginate(12);
            $sparepart = null;
        } elseif ($category === 'sparepart') {
            $sparepart = $querySparepart->paginate(12);
            $product = null;
        } else {
            $product = $queryProduct->orderBy('id_produk', 'DESC')->take(6)->get();
            $sparepart = $querySparepart->orderBy('id_spare_part', 'DESC')->take(6)->get();
        }

        return view('ProductSparepart.index', compact('sparepart', 'product', 'category'));
    }

    public function detail($type, $id)
    {
        if ($type == 'product') {
            $data = Product::where('id_produk', $id)->first();
            $photos = FotoProduk::where('id_produk', $id)->first();

            $soldQuantity = OrderItemOnline::where('id_produk', $id)
                            ->whereHas('orderOnline', function ($query) {
                                $query->where('status_order', 'SELESAI');
                            })
                            ->sum('qty') +
                            OrderItem::where('id_produk', $id)
                            ->whereHas('order', function ($query) {
                                $query->where('status', 'SUCCESS');
                            })
                            ->sum('qty');
        } elseif ($type == 'sparepart') {
            $data = SpareParts::where('id_spare_part', $id)->first();
            $photos = FotoSparepart::where('id_spare_part', $id)->first();

            $soldQuantity = OrderItemOnline::where('id_spare_part', $id)
                            ->whereHas('orderOnline', function ($query) {
                                $query->where('status_order', 'SELESAI');
                            })
                            ->sum('qty') +
                            OrderItem::where('id_spare_part', $id)
                            ->whereHas('order', function ($query) {
                                $query->where('status', 'SUCCESS');
                            })
                            ->sum('qty');
        } else {
            abort(404);
        }

        if (!$data || !$photos) {
            abort(404);
        }

        $photoArray = [];
        for ($i = 1; $i <= 5; $i++) {
            $column = $type === 'product' ? "file_foto_produk_$i" : "file_foto_spare_part_$i";
            if (!empty($photos->$column)) {
                $photoArray[] = url($photos->$column);
            }
        }

        $mainPhoto = $photoArray[0] ?? asset('assets/images/default.png');
        $thumbnailPhotos = array_slice($photoArray, 1);

        $data->load('bengkel');

        return view('ProductSparepart.detail-ProductSparePart', compact('data', 'mainPhoto', 'thumbnailPhotos', 'soldQuantity'));
    }
}

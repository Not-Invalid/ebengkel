<?php

namespace App\Http\Controllers;

use App\Models\OrderOnline;
use App\Models\OrderItemOnline;
use App\Models\Invoice;
use App\Models\Bengkel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\RajaOngkirService;

class PaymentController extends Controller
{
    public function index(Request $request, $order_id, $id, RajaOngkirService $rajaOngkirService)
    {
        $order = OrderOnline::where("order_id", $order_id)->first();

        if (!$order) {
            return redirect()
                ->route("home")
                ->with("error", "Order tidak ditemukan.");
        }

        $invoice = Invoice::find($id);

        if (!$invoice) {
            return redirect()
                ->route("home")
                ->with("error", "Invoice tidak ditemukan.");
        }

        $bengkel = Bengkel::find($order->id_bengkel);

        if (!$bengkel) {
            return redirect()
                ->route("home")
                ->with("error", "Bengkel tidak ditemukan untuk order ini.");
        }

        $shippingAddress = Auth::user()->alamatPengiriman->first();
        $shippingAddress->status_alamat_pengiriman;

        $weight = 1000;

        $originCity = $bengkel->kota_id;

        $destinationCity = $order->kabupaten;

        $courier = $request->input("shipping_courier", "jne");

        $shippingCostData = $rajaOngkirService->getShippingCost(
            $originCity,
            $destinationCity,
            $weight,
            $courier
        );

        $courierOptions = [];
        if (
            $shippingCostData &&
            isset($shippingCostData["rajaongkir"]["results"][0]["costs"])
        ) {
            foreach ($shippingCostData["rajaongkir"]["results"] as $result) {
                $courierName = isset($result["name"])
                    ? $result["name"]
                    : "Unknown Courier";

                foreach ($result["costs"] as $cost) {
                    $courierOptions[] = [
                        "courier" => $courierName,
                        "service" => $cost["service"],
                        "description" => $cost["description"],
                        "cost" => $cost["cost"][0]["value"],
                        "delivery_time" => $cost["cost"][0]["etd"],
                    ];
                }
            }
        }

        $dueDate = \Carbon\Carbon::parse($order->tanggal)->addDay(1);
        $currentDate = \Carbon\Carbon::now();
        $isDueDatePassed = $currentDate->greaterThan($dueDate);

        $orderItems = OrderItemOnline::with(["produk", "sparepart"])
                                      ->where("id_order_online", $order->id)
                                      ->get();

        $produkItem = null;
        $sparepartItem = null;
        foreach ($orderItems as $item) {
            if ($item->id_produk) {
                $produkItem = $item->produk;
            } else {
                $sparepartItem = $item->sparepart;
            }
        }

        $paymentMethods = is_array($bengkel->payment) ? $bengkel->payment : json_decode($bengkel->payment, true);
        $rekeningBank = is_array($bengkel->rekening_bank) ? $bengkel->rekening_bank : json_decode($bengkel->rekening_bank, true);


        return view(
            "transaction.payment",
            compact(
                "order",
                "produkItem",
                "sparepartItem",
                "bengkel",
                "paymentMethods",
                "rekeningBank",
                "invoice",
                "isDueDatePassed",
                "courierOptions"
            )
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "jenis_pembayaran" => "required|string|max:50",
            "nama_rekening" =>
                "required_if:jenis_pembayaran,Manual Transfer|string|max:100",
            "no_rekening" =>
                "required_if:jenis_pembayaran,Manual Transfer|string|max:50",
            "bank_tujuan" =>
                "required_if:jenis_pembayaran,Manual Transfer|string|max:100",
            "nominal_transfer" => "required|string",
            "bukti_bayar" => "required|image|mimes:jpeg,png,jpg,gif|max:2048",
            "note" => "nullable|string",
            "id" => "required|integer",
        ]);

        $order = OrderOnline::where("order_id", $request->order_id)->first();
        $shipping_method = $request->shipping_method;
        $shipping_courier = $request->shipping_courier;
        $shipping_cost = $request->shipping_cost ?? 0;
        $grandTotal = $order->total_harga + $shipping_cost;

        $order->jenis_pengiriman = $shipping_method;
        $order->kurir = $shipping_courier;
        $order->biaya_pengiriman = $shipping_cost;
        $order->grand_total = $grandTotal;

        if (!$order) {
            return redirect()
                ->route("home")
                ->with("error", "Order tidak ditemukan.");
        }

        $invoice = Invoice::find($request->id);

        if (!$invoice) {
            return redirect()
                ->route("payment", [
                    "order_id" => $order->order_id,
                    "invoice_id" => $request->id,
                ])
                ->with("error", "Invoice tidak ditemukan.");
        }

        $buktiBayarPath = null;

        if ($request->hasFile("bukti_bayar")) {
            $buktiBayarImage = $request->file("bukti_bayar");
            $buktiBayarFileName =
                "bukti_bayar_" . now()->format("Ymd_His") . ".webp";

            $img = imagecreatefromstring(file_get_contents($buktiBayarImage));

            if ($img) {
                if (imageistruecolor($img) === false) {
                    $trueColorImg = imagecreatetruecolor(
                        imagesx($img),
                        imagesy($img)
                    );

                    imagecopy(
                        $trueColorImg,
                        $img,
                        0,
                        0,
                        0,
                        0,
                        imagesx($img),
                        imagesy($img)
                    );
                    imagedestroy($img);
                    $img = $trueColorImg;
                }

                imagewebp(
                    $img,
                    public_path(
                        "assets/images/bukti_bayar/" . $buktiBayarFileName
                    ),
                    90
                );
                imagedestroy($img);

                $buktiBayarPath = url(
                    "assets/images/bukti_bayar/" . $buktiBayarFileName
                );
            }
        }

        $invoice->tanggal_bayar = now();
        $invoice->tanggal_transfer = now()->format("Y-m-d");
        $invoice->nama_rekening = $request->nama_rekening;
        $invoice->no_rekening = $request->no_rekening;
        $invoice->jenis_pembayaran = $request->jenis_pembayaran;
        $invoice->bank_tujuan = $request->bank_tujuan;
        $invoice->nominal_transfer = $request->nominal_transfer;
        $invoice->bukti_bayar = $buktiBayarPath;
        $invoice->note = $request->note;
        $invoice->status_invoice = "Waiting_Confirmation";
        $invoice->save();

        $order->status_order = "Waiting_Confirmation";
        $order->save();

        return redirect()
            ->route("home")
            ->with("status", "Pembayaran berhasil, tunggu konfirmasi.");
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('RAJAONGKIR_API_KEY'); // Pastikan API Key disimpan di .env
        $this->baseUrl = 'https://api.rajaongkir.com/starter/'; // URL API RajaOngkir
    }

    // Mendapatkan estimasi ongkir dari RajaOngkir
    public function getShippingCost($originCity, $destinationCity, $weight, $courier)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->post($this->baseUrl . 'cost', [
            'origin' => $originCity,       // ID kota asal (misalnya ID kota bengkel)
            'destination' => $destinationCity, // ID kota tujuan (misalnya ID kota alamat pengiriman)
            'weight' => $weight,           // Berat barang dalam gram
            'courier' => $courier,         // Kurir yang dipilih (misalnya 'jne', 'tiki', 'pos')
        ]);

        // Debugging: cek respons API
        Log::info($response->json());


        // Memeriksa apakah request berhasil
        if ($response->successful()) {
            return $response->json(); // Mengembalikan data dalam bentuk JSON jika sukses
        }

        return null; // Mengembalikan null jika ada error dalam request API
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\PesananService;
use App\Models\Product;
use App\Models\Provinsi;
use App\Models\ReviewWorkshop;
use App\Models\Service;
use App\Models\SpareParts;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WorkshopController extends Controller
{
    public function show(Request $request)
    {
        $query = Bengkel::where('delete_bengkel', 'N');
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nama_bengkel', 'LIKE', '%' . $search . '%');
        }
        $bengkels = $query->get();
        $bengkels = $query->orderBy('create_bengkel', 'DESC')->paginate(12);
        return view('workshop.index', compact('bengkels'));
    }

    public function detail($id, $type = null, $itemId = null)
    {
        $bengkel = Bengkel::where('id_bengkel', $id)
            ->where('delete_bengkel', 'N')
            ->first();

        if (!$bengkel) {
            return redirect()->route('workshop.show')->with('status_error', 'Workshop not found.');
        }

        $services = Service::where('id_bengkel', $id)
            ->where('delete_services', 'N')
            ->paginate(8); // Add pagination

        $products = Product::where('id_bengkel', $id)
            ->where('delete_produk', 'N')
            ->paginate(8); // Add pagination

        $spareparts = SpareParts::where('id_bengkel', $id)
            ->where('delete_spare_part', 'N')
            ->paginate(8); // Add pagination
        // Check if a specific product or spare part detail is requested
        $detailData = null;
        if ($type && $itemId) {
            if ($type == 'product') {
                $detailData = Product::where('id_product', $itemId)->first();
            } elseif ($type == 'sparepart') {
                $detailData = SpareParts::where('id_spare_part', $itemId)->first();
            }

            // Check if detail data exists and load related workshop data
            if ($detailData) {
                $detailData->load('bengkel');
            } else {
                return redirect()->back()->with('status_error', ucfirst($type) . ' not found.');
            }
        }

        $bengkel->open_time = Carbon::parse($bengkel->open_time)->format('H:i');
        $bengkel->close_time = Carbon::parse($bengkel->close_time)->format('H:i');

        $serviceAvailable = json_decode($bengkel->service_available, true);
        $paymentMethods = json_decode($bengkel->payment, true);

        $ulasan = ReviewWorkshop::with('pelanggan')->where('id_bengkel', $id)->get();
        $averageRating = $ulasan->avg('rating');
        $totalReviews = $ulasan->count();

        if ($totalReviews == 0) {
            $ratingCategory = __('messages.workshop.rating_category_none');
        } elseif ($averageRating < 2) {
            $ratingCategory = __('messages.workshop.rating_bad');
        } elseif ($averageRating >= 2 && $averageRating < 3) {
            $ratingCategory = __('messages.workshop.rating_good');
        } elseif ($averageRating >= 3 && $averageRating < 4) {
            $ratingCategory = __('messages.workshop.rating_very_good');
        } elseif ($averageRating >= 4 && $averageRating < 4.5) {
            $ratingCategory = __('messages.workshop.rating_excellent');
        } elseif ($averageRating >= 4.5) {
            $ratingCategory = __('messages.workshop.rating_outstanding');
        }

        return view('workshop.detail', compact(
            'bengkel',
            'serviceAvailable',
            'paymentMethods',
            'services',
            'products',
            'spareparts',
            'detailData',
            'ulasan',
            'averageRating',
            'totalReviews',
            'ratingCategory'
        ));
    }

    public function showWorkshop()
    {
        if (!Session::has('id_pelanggan')) {
            return redirect()->route('home')->with('status_error', 'You must be logged in to see workshop.');
        }

        $bengkels = Bengkel::with('pelanggan')
            ->where('id_pelanggan', Session::get('id_pelanggan'))
            ->where('delete_bengkel', 'N')
            ->get();
        return view('profile.workshop.index', compact('bengkels'));
    }

    public function createWorkshop()
    {
        if (!Session::has('id_pelanggan')) {
            return redirect()->route('home')->with('status_error', 'You must be logged in to see workshop.');
        }

        $provinces = Provinsi::all();
        return view('profile.workshop.create', compact('provinces'));
    }

    public function getLocations(Request $request)
    {
        $response = [];

        if ($request->has('province_id')) {
            $cities = Kota::where('province_id', $request->province_id)->get();
            $response['cities'] = $cities;
        }

        if ($request->has('city_id')) {
            $subdistricts = Kecamatan::where('city_id', $request->city_id)->get();
            $response['subdistricts'] = $subdistricts;
        }

        return response()->json($response);
    }

    public function storeWorkshop(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'foto_cover_bengkel' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_bengkel' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_bengkel' => 'required|string|max:50',
            'tagline_bengkel' => 'nullable|string|max:50',
            'alamat_bengkel' => 'required|string',
            'gmaps' => 'nullable|string',
            'open_day' => 'required|string',
            'close_day' => 'nullable|string',
            'open_time' => 'required|string',
            'close_time' => 'required|string',
            'service_available' => 'nullable|array',
            'service_available.*' => 'string',
            'payment' => 'nullable|array',
            'payment.*' => 'string',
            'whatsapp' => 'nullable|string|max:15',
            'instagram' => 'nullable|string',
            'rekening_bank' => 'nullable|array',
            'rekening_bank.*.no_rekening' => 'required|string|max:100',
            'rekening_bank.*.nama_bank' => 'required|string|max:100',
            'rekening_bank.*.atas_nama' => 'required|string|max:100',
            'qris_qrcode' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'provinsi_id' => 'required|string',
            'kota_id' => 'required|string',
            'kecamatan_id' => 'required|string',
        ]);

        // Add the customer ID from the session
        $validatedData['id_pelanggan'] = Session::get('id_pelanggan');

        // Handle the 'service_available' and 'payment' fields (encode them as JSON)
        $validatedData['service_available'] = json_encode($request->service_available ?? []);
        $validatedData['payment'] = json_encode($request->payment ?? []);

        // Convert the open_time and close_time to the required format (HH:mm)
        $validatedData['open_time'] = Carbon::createFromFormat('H:i', $request->open_time)->format('H:i');
        $validatedData['close_time'] = Carbon::createFromFormat('H:i', $request->close_time)->format('H:i');

        // Store the province, city, and district
        $validatedData['provinsi_id'] = $request->provinsi_id;
        $validatedData['kota_id'] = $request->kota_id;
        $validatedData['kecamatan_id'] = $request->kecamatan_id;

        // Handle the bank account information
        if ($request->has('rekening_bank')) {
            $validatedData['rekening_bank'] = json_encode($request->rekening_bank);
        }

        // Custom image upload handling for 'foto_bengkel'
        if ($request->hasFile('foto_bengkel')) {
            $image = $request->file('foto_bengkel');
            $imageName = 'foto_bengkel_' . now()->format('Ymd_His') . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/workshops/profile'), $imageName);
            $validatedData['foto_bengkel'] = url('assets/images/workshops/profile/' . $imageName);
        } else {
            $validatedData['foto_bengkel'] = url('assets/images/components/image.png');
        }

        // Custom image upload handling for 'foto_cover_bengkel'
        if ($request->hasFile('foto_cover_bengkel')) {
            $coverImage = $request->file('foto_cover_bengkel');
            $coverImageName = 'foto_cover_bengkel_' . now()->format('Ymd_His') . '.' . $coverImage->getClientOriginalExtension();
            $coverImage->move(public_path('assets/images/workshops/cover'), $coverImageName);
            $validatedData['foto_cover_bengkel'] = url('assets/images/workshops/cover/' . $coverImageName);
        } else {
            $validatedData['foto_cover_bengkel'] = url('assets/images/components/image.png');
        }

        // Handle the QRIS QR code upload
        if ($request->hasFile('qris_qrcode')) {
            $qrisImage = $request->file('qris_qrcode');
            $qrisImageName = 'qris_qrcode_' . now()->format('Y md_His') . '.' . $qrisImage->getClientOriginalExtension();
            $qrisImage->move(public_path('assets/images/workshops/qris'), $qrisImageName);
            $validatedData['qris_qrcode'] = url('assets/images/workshops/qris/' . $qrisImageName);
        }

        // Store the workshop data in the database
        Bengkel::create($validatedData);

        return redirect()->route('profile.workshop')->with('status', 'Workshop created successfully.');
    }
    public function editWorkshop($id)
    {
        $customerId = Session::get('id_pelanggan');
        $bengkel = Bengkel::where('id_bengkel', $id)
            ->where('id_pelanggan', $customerId)
            ->first();

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        // Decode the 'payment' and 'service_available' fields if they are stored as JSON strings
        $bengkel->payment = is_string($bengkel->payment) ? json_decode($bengkel->payment, true) : $bengkel->payment;
        $bengkel->service_available = is_string($bengkel->service_available) ? json_decode($bengkel->service_available, true) :
            $bengkel->service_available;

        // Decode the 'rekening_bank' field as well
        $bankAccounts = is_string($bengkel->rekening_bank) ? json_decode($bengkel->rekening_bank, true) : $bengkel->rekening_bank;
        $bankAccounts = is_array($bankAccounts) ? $bankAccounts : [];

        // Assign variables for use in the view
        $serviceAvailable = $bengkel->service_available ?? [];
        $paymentMethods = $bengkel->payment ?? [];

        // Pass the bankAccounts data to the view

        $provinces = Provinsi::all();
        $cities = Kota::where('province_id', $bengkel->provinsi_id)->get();
        $subdistricts = Kecamatan::where('city_id', $bengkel->kota_id)->get();

        return view('profile.workshop.edit', compact('bengkel', 'serviceAvailable', 'paymentMethods', 'bankAccounts', 'provinces', 'cities', 'subdistricts'));
    }

    public function updateWorkshop(Request $request, $id)
    {
        $bengkel = Bengkel::findOrFail($id);

        // Ensure the user is editing their own workshop
        if ($bengkel->id_pelanggan !== Session::get('id_pelanggan')) {
            return redirect()->route('profile.workshop')->with('error', 'You do not have permission to update this workshop.');
        }

        // Validate the input data, including the service_available and payment arrays
        $validatedData = $request->validate([
            'foto_cover_bengkel' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_bengkel' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama_bengkel' => 'required|string|max:50',
            'tagline_bengkel' => 'nullable|string|max:50',
            'alamat_bengkel' => 'required|string',
            'gmaps' => 'nullable|string',
            'open_day' => 'required|string',
            'close_day' => 'nullable|string',
            'open_time' => 'required|string', // Expecting a time string
            'close_time' => 'required|string', // Expecting a time string
            'service_available' => 'nullable|array',
            'service_available.*' => 'string',
            'payment' => 'nullable|array',
            'payment.*' => 'string',
            'rekening_bank' => 'nullable|array',
            'rekening_bank.*.no_rekening' => 'required|string|max:100',
            'rekening_bank.*.nama_bank' => 'required|string|max:100',
            'rekening_bank.*.atas_nama' => 'required|string|max:100',
            'qris_qrcode' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'whatsapp' => 'nullable|string|max:15',
            'instagram' => 'nullable|string',
            'provinsi_id' => 'required|string',
            'kota_id' => 'required|string',
            'kecamatan_id' => 'required|string',
        ]);

        // Handle the 'service_available' and 'payment' fields (encode them as JSON)
        $validatedData['service_available'] = json_encode($request->service_available ?? []);
        $validatedData['payment'] = json_encode($request->payment ?? []);

        if ($request->has('rekening_bank')) {
            $validatedData['rekening_bank'] = json_encode($request->rekening_bank);
        }

        // Convert the open_time and close_time to the required format (HH:mm)
        $validatedData['open_time'] = Carbon::createFromFormat('H:i:s', trim($request->open_time))->format('H:i');
        $validatedData['close_time'] = Carbon::createFromFormat('H:i:s', trim($request->close_time))->format('H:i');

        // Handle the foto_bengkel file upload
        if ($request->hasFile('foto_bengkel')) {
            $image = $request->file('foto_bengkel');
            $imageName = 'foto_bengkel_' . now()->format('Ymd_His') . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/workshops/profile'), $imageName);
            $validatedData['foto_bengkel'] = url('assets/images/workshops/profile/' . $imageName);
        }

        // Handle the foto_cover_bengkel file upload
        if ($request->hasFile('foto_cover_bengkel')) {
            $coverImage = $request->file('foto_cover_bengkel');
            $coverImageName = 'foto_cover_bengkel_' . now()->format('Ymd_His') . '.' . $coverImage->getClientOriginalExtension();
            $coverImage->move(public_path('assets/images/workshops/cover'), $coverImageName);
            $validatedData['foto_cover_bengkel'] = url('assets/images/workshops/cover/' . $coverImageName);
        }

        if ($request->hasFile('qris_qrcode')) {
            $qrisImage = $request->file('qris_qrcode');
            $qrisImageName = 'qris_' . now()->format('Ymd_His') . '.' . $qrisImage->getClientOriginalExtension();
            $qrisImage->move(public_path('assets/images/workshops/qris'), $qrisImageName);
            $validatedData['qris_qrcode'] = 'assets/images/workshops/qris/' . $qrisImageName; // Menyimpan path file
        }
        // Update the bengkel record with validated data
        $bengkel->update($validatedData);

        return redirect()->route('profile.workshop')->with('status', 'Workshop updated successfully.');
    }

    public function destroyWorkshop($id)
    {
        $bengkel = DB::table('tb_bengkel')->where('id_bengkel', $id)->first();

        if ($bengkel) {
            DB::table('tb_bengkel')->where('id_bengkel', $id)->update([
                'delete_bengkel' => 'Y',
            ]);
            return redirect()->route('profile.workshop')->with('status', 'Workshop deleted successfully.');
        } else {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }
    }

    public function detailWorkshop($id)
    {
        $customerId = Session::get('id_pelanggan');
        $bengkel = Bengkel::where('id_bengkel', $id)
            ->where('id_pelanggan', $customerId)
            ->where('delete_bengkel', 'N')
            ->first();

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        $bengkel->payment = is_string($bengkel->payment) ? json_decode($bengkel->payment, true) : $bengkel->payment;
        $bengkel->service_available = is_string($bengkel->service_available) ? json_decode($bengkel->service_available, true) :
            $bengkel->service_available;

        $serviceAvailable = $bengkel->service_available ?? [];
        $paymentMethods = $bengkel->payment ?? [];

        $sparepart = SpareParts::where('id_bengkel', $id)
            ->where('delete_spare_part', 'N')
            ->get();
        $produk = Product::where('id_bengkel', $id)
            ->where('delete_produk', 'N')
            ->get();
        $services = Service::where('id_bengkel', $id)->where('delete_services', 'N')->get();
        return view('profile.workshop.detail', compact(
            'bengkel',
            'serviceAvailable',
            'paymentMethods',
            'id',
            'sparepart',
            'produk',
            'services'
        ));
    }
    public function detailService($id_bengkel, $id_services)
    {
        // Retrieve the service details from the database
        $service = Service::with('bengkel') // Mengambil relasi bengkel
            ->where('id_services', $id_services)
            ->where('id_bengkel', $id_bengkel)
            ->where('delete_services', '!=', 'Y')
            ->first();

        // Check if the service exists
        if (!$service) {
            return redirect()->back()->with('status_error', 'Service not found.');
        }
        // Controller
        $services = Service::with('bengkel')->find($id_bengkel);

        // Pass the service data to the view
        return view('service.detail', compact('service', 'id_bengkel', 'id_services'));
    }

    public function showPesananService($id_bengkel, $id_services)
    {
        // Get service information
        $service = Service::with('bengkel')
            ->where('id_services', $id_services)
            ->where('id_bengkel', $id_bengkel)
            ->where('delete_services', '!=', 'Y')
            ->first();

        if (!$service) {
            return redirect()->back()->with('status_error', 'Service not found.');
        }

        // Initialize arrays for tracking
        $bookedDates = [];
        $availableDates = [];
        $stockPerDate = [];

        // Check availability for next 3 days
        for ($i = 0; $i < 3; $i++) {
            $date = now()->addDays($i)->format('Y-m-d');

            // Get count of existing bookings for this service on this date
            $existingOrdersCount = PesananService::where('id_bengkel', $id_bengkel)
                ->where('tgl_pesanan', $date)
                ->where('nama_services', $service->nama_services)
                ->count();

            // Calculate remaining stock for this date
            $remainingStock = $service->jumlah_services_online - $existingOrdersCount;

            // Store the remaining stock information
            $stockPerDate[$date] = $remainingStock;

            if ($remainingStock > 0) {
                $availableDates[] = $date;
            } else {
                $bookedDates[] = $date;
            }
        }

        return view('service.pesanan', compact(
            'id_bengkel',
            'id_services',
            'service',
            'bookedDates',
            'availableDates',
            'stockPerDate'
        ));
    }

    public function storePesananServices(Request $request, $id_bengkel, $id_services)
    {
        $customerId = Session::get('id_pelanggan');
        if (!$customerId) {
            return redirect()->back()->with('status', 'ID pelanggan tidak ditemukan. Silakan login.');
        }

        $service = Service::find($id_services);
        if (!$service) {
            return redirect()->back()->with('status', 'Layanan tidak ditemukan.');
        }

        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'telp_pelanggan' => 'required|numeric',
            'nama_services' => 'required|string|max:255',
            'tgl_pesanan' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $selectedDate = Carbon::parse($value)->format('Y-m-d');
                    $minDate = now()->format('Y-m-d');
                    $maxDate = now()->addDays(2)->format('Y-m-d');

                    if ($selectedDate < $minDate || $selectedDate > $maxDate) {
                        $fail('Tanggal pesanan harus dalam rentang 3 hari ke depan.');
                    }
                },
            ],
        ]);

        $selectedDate = $request->tgl_pesanan;

        // Check if selected date is within the 3-day range
        if (
            Carbon::parse($selectedDate)->lt(now()) ||
            Carbon::parse($selectedDate)->gt(now()->addDays(2))
        ) {
            return redirect()->back()->withErrors([
                'tgl_pesanan' => 'Tanggal pesanan harus dalam rentang 3 hari ke depan.'
            ]);
        }

        // Check stock availability for the selected date
        $existingOrdersCount = PesananService::where('id_bengkel', $id_bengkel)
            ->where('tgl_pesanan', $selectedDate)
            ->where('nama_services', $service->nama_services)
            ->count();

        if ($existingOrdersCount >= $service->jumlah_services_online) {
            return redirect()->back()->withErrors([
                'status' => 'Stok layanan untuk tanggal ini sudah habis. Silakan pilih tanggal lain.'
            ]);
        }

        PesananService::create([
            'id_pelanggan' => $customerId,
            'id_bengkel' => $id_bengkel,
            'telp_pelanggan' => $request->telp_pelanggan,
            'nama_pemesan' => $request->nama_pemesan,
            'tgl_pesanan' => $selectedDate,
            'nama_services' => $service->nama_services,
            'status' => 'Waiting_List',
            'jumlah_services_online' => $existingOrdersCount + 1,
            'total_pesanan' => $service->harga_services,
        ]);

        return redirect()->route('service.detail', ['id_bengkel' => $id_bengkel, 'id_services' => $id_services])
            ->with('status', 'Pesanan layanan berhasil dibuat.');
    }

    public function storeReview(Request $request)
    {
        $customerId = Session::get('id_pelanggan');
        $request->validate([
            'id_pelanggan' => 'required|integer',
            'id_bengkel' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);
        ReviewWorkshop::create([
            'id_pelanggan' => $customerId,
            'id_bengkel' => $request->id_bengkel,
            'rating' => $request->rating,
            'komentar' => $request->komentar, // Pastikan komentar ini diterima
        ]);
        return redirect()->back()->with('status', 'Sending Review');
    }
}

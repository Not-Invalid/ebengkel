<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\SpareParts;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class WorkshopController extends Controller
{
    public function show()
    {
        $bengkels = Bengkel::where('delete_bengkel', 'N')->get();
        return view('workshop.index', compact('bengkels'));
    }

    public function detail($id)
    {
        $bengkel = Bengkel::where('id_bengkel', $id)
            ->where('delete_bengkel', 'N')
            ->first();

        if (!$bengkel) {
            return redirect()->route('workshop.index')->with('error_status', 'Workshop not found.');
        }

        $services = Service::where('id_bengkel', $id)->where('delete_services', 'N')->get();
        $bengkel->open_time = Carbon::parse($bengkel->open_time)->format('H:i');
        $bengkel->close_time = Carbon::parse($bengkel->close_time)->format('H:i');

        // Decode the JSON fields into arrays
        $serviceAvailable = json_decode($bengkel->service_available, true);
        $paymentMethods = json_decode($bengkel->payment, true);

        return view('workshop.detail', compact('bengkel', 'serviceAvailable', 'paymentMethods','services'));
    }

    public function showWorkshop()
    {
        if (!Session::has('id_pelanggan')) {
            return redirect()->route('home')->with('error_status', 'You must be logged in to add an address.');
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
            return redirect()->route('home')->with('error_status', 'You must be logged in to add an address.');
        }
        return view('profile.workshop.create');
    }

    public function storeWorkshop(Request $request)
{
    $validatedData = $request->validate([
        'foto_cover_bengkel' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'foto_bengkel' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'nama_bengkel' => 'required|string|max:50',
        'tagline_bengkel' => 'nullable|string|max:50',
        'alamat_bengkel' => 'required|string',
        'gmaps' => 'nullable|string',
        'open_day' => 'required|string',
        'close_day' => 'nullable|string',
        'open_time' => 'required|string',  // Expecting a time string
        'close_time' => 'required|string',  // Expecting a time string
        'service_available' => 'nullable|array',
        'service_available.*' => 'string',
        'payment' => 'nullable|array',
        'payment.*' => 'string',
        'whatsapp' => 'nullable|string|max:15',
        'instagram' => 'nullable|string',
    ]);

    $validatedData['id_pelanggan'] = Session::get('id_pelanggan');

    // Handle the 'service_available' and 'payment' fields (encode them as JSON)
    $validatedData['service_available'] = json_encode($request->service_available ?? []);
    $validatedData['payment'] = json_encode($request->payment ?? []);

    // Convert the open_time and close_time to the required format (HH:mm)
    $validatedData['open_time'] = Carbon::createFromFormat('H:i', $request->open_time)->format('H:i');
    $validatedData['close_time'] = Carbon::createFromFormat('H:i', $request->close_time)->format('H:i');

    // Custom image upload handling for 'foto_bengkel'
    if ($request->hasFile('foto_bengkel')) {
        $image = $request->file('foto_bengkel');
        $imageName = 'foto_bengkel_' . now()->format('Ymd_His') . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/images/workshops/profile'), $imageName);
        $validatedData['foto_bengkel'] = url('assets/images/workshops/profile/' . $imageName);
    } else {
        $validatedData['foto_bengkel'] = url('assets/images/default-workshop.jpg');
    }

    // Custom image upload handling for 'foto_cover_bengkel'
    if ($request->hasFile('foto_cover_bengkel')) {
        $coverImage = $request->file('foto_cover_bengkel');
        $coverImageName = 'foto_cover_bengkel_' . now()->format('Ymd_His') . '.' . $coverImage->getClientOriginalExtension();
        $coverImage->move(public_path('assets/images/workshops/cover'), $coverImageName);
        $validatedData['foto_cover_bengkel'] = url('assets/images/workshops/cover/' . $coverImageName);
    } else {
        $validatedData['foto_cover_bengkel'] = url('assets/images/default-cover.jpg');
    }

    Bengkel::create($validatedData);

    return redirect()->route('profile.workshop')->with('status', 'Workshop created successfully.');
}

    // public function editWorkshop($id)
    // {
    //     $customerId = Session::get('id_pelanggan');
    //     $bengkel = Bengkel::where('id_bengkel', $id)
    //         ->where('id_pelanggan', $customerId)
    //         ->first();

    //     if (!$bengkel) {
    //         return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found.');
    //     }

    //     // Decode the 'payment' and 'service_available' fields if they are stored as JSON strings
    //     $bengkel->payment = is_string($bengkel->payment) ? json_decode($bengkel->payment) : $bengkel->payment;
    //     $bengkel->service_available = is_string($bengkel->service_available) ? json_decode($bengkel->service_available) : $bengkel->service_available;

    //     return view('profile.workshop.edit', compact('bengkel'));
    // }

    public function editWorkshop($id)
    {
        $customerId = Session::get('id_pelanggan');
        $bengkel = Bengkel::where('id_bengkel', $id)
            ->where('id_pelanggan', $customerId)
            ->first();

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found.');
        }

        // Decode the 'payment' and 'service_available' fields if they are stored as JSON strings
        $bengkel->payment = is_string($bengkel->payment) ? json_decode($bengkel->payment, true) : $bengkel->payment;
        $bengkel->service_available = is_string($bengkel->service_available) ? json_decode($bengkel->service_available, true) : $bengkel->service_available;

        // Assign variables for use in the view
        $serviceAvailable = $bengkel->service_available ?? [];
        $paymentMethods = $bengkel->payment ?? [];

        return view('profile.workshop.edit', compact('bengkel', 'serviceAvailable', 'paymentMethods'));
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
            'foto_cover_bengkel' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_bengkel' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_bengkel' => 'required|string|max:50',
            'tagline_bengkel' => 'nullable|string|max:50',
            'alamat_bengkel' => 'required|string',
            'gmaps' => 'nullable|string',
            'open_day' => 'required|string',
            'close_day' => 'nullable|string',
            'open_time' => 'required|string',  // Expecting a time string
            'close_time' => 'required|string',  // Expecting a time string
            'service_available' => 'nullable|array',
            'service_available.*' => 'string',
            'payment' => 'nullable|array',
            'payment.*' => 'string',
            'whatsapp' => 'nullable|string|max:15',
            'instagram' => 'nullable|string',
        ]);

        // Handle the 'service_available' and 'payment' fields (encode them as JSON)
        $validatedData['service_available'] = json_encode($request->service_available ?? []);
        $validatedData['payment'] = json_encode($request->payment ?? []);


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
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found.');
        }
    }

    public function detailWorkshop($id)
    {
        $customerId = Session::get('id_pelanggan');
        $bengkel = Bengkel::where('id_bengkel', $id)
            ->where('id_pelanggan', $customerId)
            ->where('delete_bengkel', 'N')
            ->first();
<<<<<<< HEAD

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found.');
        }

        $bengkel->payment = is_string($bengkel->payment) ? json_decode($bengkel->payment, true) : $bengkel->payment;
        $bengkel->service_available = is_string($bengkel->service_available) ? json_decode($bengkel->service_available, true) : $bengkel->service_available;

        $serviceAvailable = $bengkel->service_available ?? [];
        $paymentMethods = $bengkel->payment ?? [];

        $sparepart = SpareParts::where('id_bengkel', $id)
            ->where('delete_spare_part', 'N')
            ->get();

        return view('profile.workshop.detail', compact('bengkel', 'serviceAvailable', 'paymentMethods', 'id', 'sparepart'));
    }

}
=======

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found.');
        }

        // Decode the 'payment' and 'service_available' fields if they are stored as JSON strings
        $bengkel->payment = is_string($bengkel->payment) ? json_decode($bengkel->payment, true) : $bengkel->payment;
        $bengkel->service_available = is_string($bengkel->service_available) ? json_decode($bengkel->service_available, true) : $bengkel->service_available;

        // Ambil data service yang terkait dengan bengkel
        $services = Service::where('id_bengkel', $id)->where('delete_services', 'N')->get();

        // Assign variables for use in the view
        $serviceAvailable = $bengkel->service_available ?? [];
        $paymentMethods = $bengkel->payment ?? [];

        return view('profile.workshop.detail', compact('bengkel', 'serviceAvailable', 'paymentMethods', 'services'));
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
            return redirect()->back()->with('error_status', 'Service not found.');
        }
    // Controller
            $services = Service::with('bengkel')->find($id_bengkel);

        // Pass the service data to the view
        return view('service.detail', compact('service'));
    }

}
>>>>>>> daw

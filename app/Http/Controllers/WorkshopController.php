<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class WorkshopController extends Controller
{
    public function show()
    {
        $bengkels = Bengkel::where('delete_bengkel', 'N')->get();
        return view('workshop.index', compact('bengkels'));
    }

    public function detail()
    {
        return view('workshop.detail');
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
            'open_time' => 'required',
            'close_time' => 'required',
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

        return redirect()->route('profile.workshop')->with('success', 'Workshop created successfully.');
    }

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
        $bengkel->payment = is_string($bengkel->payment) ? json_decode($bengkel->payment) : $bengkel->payment;
        $bengkel->service_available = is_string($bengkel->service_available) ? json_decode($bengkel->service_available) : $bengkel->service_available;

        return view('profile.workshop.edit', compact('bengkel'));
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
            'open_time' => 'required',
            'close_time' => 'required',
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

        return redirect()->route('profile.workshop')->with('success', 'Workshop updated successfully.');
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
}

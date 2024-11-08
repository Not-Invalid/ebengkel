<?php

namespace App\Http\Controllers;

use App\Models\Bengkel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $bengkels = Bengkel::with('pelanggan')
        ->where('id_pelanggan', Session::get('id_pelanggan'))
        ->where('delete_bengkel', 'N')
        ->get();
    return view('profile.workshop.index', compact('bengkels'));
    }

    public function createWorkshop()
    {
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

                // Custom image upload handling for 'foto_bengkel'
        if ($request->hasFile('foto_bengkel')) {
            $image = $request->file('foto_bengkel');
            $imageName = 'foto_bengkel_' . now()->format('Ymd_His') . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/workshops/profile'), $imageName);
            $validatedData['foto_bengkel'] = url('assets/images/workshops/profile/' . $imageName);
        } else {
            // Default image path if no image is uploaded
            $validatedData['foto_bengkel'] = url('assets/images/default-workshop.jpg');
        }

        // Custom image upload handling for 'foto_cover_bengkel'
        if ($request->hasFile('foto_cover_bengkel')) {
            $coverImage = $request->file('foto_cover_bengkel');
            $coverImageName = 'foto_cover_bengkel_' . now()->format('Ymd_His') . '.' . $coverImage->getClientOriginalExtension();
            $coverImage->move(public_path('assets/images/workshops/cover'), $coverImageName);
            $validatedData['foto_cover_bengkel'] = url('assets/images/workshops/cover/' . $coverImageName);
        } else {
            // Default cover image path if no image is uploaded
            $validatedData['foto_cover_bengkel'] = url('assets/images/default-cover.jpg');
        }

        // Assign JSON values for service_available and payment (model casting handles this)
        $validatedData['service_available'] = $request->service_available ?? [];
        $validatedData['payment'] = $request->payment ?? [];

        Bengkel::create($validatedData);

        return redirect()->route('profile.workshop')->with('status', 'Workshop created successfully.');
    }

    public function editWorkshop($id)
    {
        // Fetch the workshop by ID
        $bengkel = Bengkel::findOrFail($id);
        $serviceAvailable = is_array($bengkel->service_available) 
        ? $bengkel->service_available 
        : json_decode($bengkel->service_available, true) ?? [];
    
        $paymentMethods = is_array($bengkel->payment) 
        ? $bengkel->payment 
        : json_decode($bengkel->payment, true) ?? [];
    
        return view('profile.workshop.edit', compact('bengkel','serviceAvailable','paymentMethods'));
    }

    public function updateWorkshop(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'nama_bengkel' => 'required|string|max:255',
            'tagline_bengkel' => 'nullable|string|max:255',
            'alamat_bengkel' => 'required|string',
            'gmaps' => 'nullable|url',
            'open_day' => 'required|string',
            'close_day' => 'nullable|string',
            'open_time' => 'required',
            'close_time' => 'required',
            'service_available' => 'required|string',
            'foto_cover_bengkel' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_bengkel' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'service_available' => 'array', 
            'payment' => 'array',  
            'whatsapp' => 'required|string|max:15',    
            'instagram' => 'nullable|string',
        ]);

        // Find the workshop
        $bengkel = Bengkel::findOrFail($id);

        // Update the workshop data
        $bengkel->nama_bengkel = $request->input('nama_bengkel');
        $bengkel->tagline_bengkel = $request->input('tagline_bengkel');
        $bengkel->alamat_bengkel = $request->input('alamat_bengkel');
        $bengkel->gmaps = $request->input('gmaps');
        $bengkel->open_day = $request->input('open_day');
        $bengkel->close_day = $request->input('close_day');
        $bengkel->open_time = $request->input('open_time');
        $bengkel->close_time = $request->input('close_time');
        $serviceAvailable = $request->input('service_available', []);
        $paymentMethods = $request->input('payment', []);
        $bengkel->whatsapp = $request->input('whatsapp');
        $bengkel->instagram = $request->input('instagram');
        // Simpan data sebagai JSON dalam kolom database
        $bengkel->service_available = json_encode($serviceAvailable);
        $bengkel->payment = json_encode($paymentMethods);
    
        // Simpan perubahan
        $bengkel->save();

        if ($request->hasFile('foto_cover_bengkel')) {
            // Delete old cover photo if it exists
            if ($bengkel->foto_cover_bengkel && file_exists(public_path('assets/images/' . basename($bengkel->foto_cover_bengkel)))) {
                unlink(public_path('assets/images/' . basename($bengkel->foto_cover_bengkel)));
            }
            // Store the new cover photo
            $coverFile = $request->file('foto_cover_bengkel');
            $coverFileName = time() . '_' . $coverFile->getClientOriginalName();
            $coverFile->move(public_path('assets/images/workshops/cover/'), $coverFileName);
            $bengkel->foto_cover_bengkel = 'assets/images/workshops/cover/' . $coverFileName;
        }
        
        if ($request->hasFile('foto_bengkel')) {
            // Delete old workshop photo if it exists
            if ($bengkel->foto_bengkel && file_exists(public_path('assets/images/' . basename($bengkel->foto_bengkel)))) {
                unlink(public_path('assets/images/' . basename($bengkel->foto_bengkel)));
            }
            // Store the new workshop photo
            $workshopFile = $request->file('foto_bengkel');
            $workshopFileName = time() . '_' . $workshopFile->getClientOriginalName();
            $workshopFile->move(public_path('assets/images/workshops/profile/'), $workshopFileName);
            $bengkel->foto_bengkel = 'assets/images/workshops/profile/' . $workshopFileName;
        }

        // Save the updated workshop
        $bengkel->save();

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
}

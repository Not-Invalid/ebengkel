<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Bengkel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ServiceController extends Controller
{
    public function createService()
    {
        if (!Session::has('id_pelanggan')) {
            return redirect()->route('home')->with('error_status', 'You must be logged in to add a service.');
        }
    
        // Ambil id_bengkel dari user yang sedang login atau sumber lain
        $id_pelanggan = Session::get('id_pelanggan');
        $bengkel = Bengkel::where('id_pelanggan', $id_pelanggan)->first();
    
        if (!$bengkel) {
            return redirect()->route('home')->with('error_status', 'No associated workshop found.');
        }
    
        $id_bengkel = $bengkel->id_bengkel;
    
        return view('profile.workshop.workshopSET.service.create', compact('id_bengkel'));
    }
    public function storeService(Request $request)
{
    $validatedData = $request->validate([
        'id_bengkel' => 'required|integer',
        'nama_services' => 'required|string|max:255',
        'keterangan_services' => 'required|string',
        'harga_services' => 'nullable|string',
        'foto_services' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($request->hasFile('foto_services')) {
        $coverImage = $request->file('foto_services');
        $coverImageName = 'foto_services_' . now()->format('Ymd_His') . '.' . $coverImage->getClientOriginalExtension();
        $coverImage->move(public_path('assets/images/service/'), $coverImageName);
        $validatedData['foto_services'] = url('assets/images/service/' . $coverImageName);
    } else {
        $validatedData['foto_services'] = url('assets/images/default-service.jpg');
    }

    Service::create($validatedData);

    return redirect()->route('profile.workshop.detail', ['id_bengkel' => $request->id_bengkel])->with('status', 'Service created successfully.');
}

    public function editService($id_services)
    {
        // Find the service by its ID
        $service = Service::find($id_services);
        
        if (!$service) {
            return redirect()->route('profile.workshop')->with('error_status', 'Service not found.');
        }
    
        // Pass the service data to the edit view
        return view('profile.workshop.workshopSET.service.edit', compact('service'));
    }
    public function updateService(Request $request, $id_services)
{
    $service = Service::findOrFail($id_services);

    $request->validate([
        'nama_services' => 'required|string|max:255',
        'keterangan_services' => 'required|string',
        'harga_services' => 'nullable|string',
        'foto_services' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $service->nama_services = $request->nama_services;
    $service->keterangan_services = $request->keterangan_services;
    $service->harga_services = $request->harga_services;

    if ($request->hasFile('foto_services')) {
        $image = $request->file('foto_services');
        $imageName = 'foto_services_' . now()->format('Ymd_His') . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/images/service/'), $imageName);
        $service->foto_services = url('assets/images/service/' . $imageName);
    }

    $service->save();

    return redirect()->route('profile.workshop.detail', ['id_bengkel' => $request->id_bengkel])->with('status', 'Service updated successfully.');
}

    public function destroyService($id_services)
    {
        // Find the service by its ID
        $service = Service::find($id_services);

        if (!$service) {
            return redirect()->route('profile.workshop')->with('error_status', 'Service not found.');
        }

        // Delete the service
        $service->delete();

        // Redirect back with a success message
        return redirect()->route('profile.workshop')->with('status', 'Service deleted successfully.');
    }

}

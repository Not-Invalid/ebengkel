<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index(Request $request, $id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!.');
        }

        if (!Auth::guard('pegawai')->check()) {
            return redirect()->route('pos.login');
        }

        $perPage = $request->get('per_page', 10);
        $service = Service::where('id_bengkel', $id_bengkel)
            ->where('delete_services', 'N')
            ->paginate(10);

        $totalEntries = $service->total();
        $start = ($service->currentPage() - 1) * $perPage + 1;
        $end = min($service->currentPage() * $perPage, $totalEntries);

        return view('pos.masterdata-service.index', compact('service', 'bengkel', 'totalEntries', 'start', 'end'));
    }

    public function create($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!.');
        }

        return view('pos.masterdata-service.create', compact('bengkel'));
    }
    public function store(Request $request, $id_bengkel)
    {
        $request->validate([
            'nama_services' => 'required|string|max:255',
            'keterangan_services' => 'required|string',
            'harga_services' => 'nullable|string',
            'foto_services' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jumlah_services_online' => 'nullable|integer',
            'jumlah_services_offline' => 'nullable|integer',
        ]);

        $service = new Service();
        $service->id_bengkel = $id_bengkel;
        $service->nama_services = $request->nama_services;
        $service->harga_services = $request->harga_services;
        $service->keterangan_services = $request->keterangan_services;
        $service->jumlah_services_online = $request->jumlah_services_online;
        $service->jumlah_services_offline = $request->jumlah_services_offline;

        if ($request->hasFile('foto_services')) {
            $imageName = 'foto_services_' . now()->format('Ymd_His') . '.' . $request->foto_services->extension();
            $request->foto_services->move(public_path('assets/images/service'), $imageName);
            $service->foto_services = 'assets/images/service/' . $imageName;
        }

        $service->save();

        return redirect()->route('pos.service.index', $id_bengkel)->with('status', 'Service successfully added!.');
    }

    public function show($id_bengkel, $id_services)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!.');
        }

        $service = Service::find($id_services);
        return view('pos.masterdata-service.show', compact('bengkel', 'service'));
    }
    public function edit($id_bengkel, $id_services)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!.');
        }

        $service = Service::findOrFail($id_services);
        return view('pos.masterdata-service.edit', compact('bengkel', 'service'));
    }

    public function update(Request $request, $id_bengkel, $id_services)
    {
        $request->validate([
            'nama_services' => 'required|string|max:255',
            'keterangan_services' => 'required|string',
            'harga_services' => 'nullable|string',
            'foto_services' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jumlah_services_online' => 'nullable|integer',
            'jumlah_services_offline' => 'nullable|integer',
        ]);

        $service = Service::findOrFail($id_services);
        $service->id_bengkel = $id_bengkel;
        $service->nama_services = $request->nama_services;
        $service->harga_services = $request->harga_services;
        $service->keterangan_services = $request->keterangan_services;
        $service->jumlah_services_online = $request->jumlah_services_online;
        $service->jumlah_services_offline = $request->jumlah_services_offline;

        if ($request->hasFile('foto_services')) {
            if ($service->foto_services && file_exists(public_path($service->foto_services))) {
                unlink(public_path($service->foto_services));
            }
            $imageName = 'foto_services_' . now()->format('Ymd_His') . '.' . $request->foto_services->extension();
            $request->foto_services->move(public_path('assets/images/service'), $imageName);
            $service->foto_services = 'assets/images/service/' . $imageName;
        }

        $service->save();

        return redirect()->route('pos.service.index', ['id_bengkel' => $id_bengkel])->with('status', 'Service successfully updated!');
    }

    public function destroy($id_bengkel, $id_services)
    {
        $service = Service::findOrFail($id_services);
        if ($service->foto_services && file_exists(public_path($service->foto_services))) {
            unlink(public_path($service->foto_services));
        }
        $service->delete();
        return redirect()->route('pos.service.index', $id_bengkel)->with('status', 'Service Successfully deleted!');
    }
}

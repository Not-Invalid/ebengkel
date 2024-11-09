<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('delete_event', 'N')->get();

        return view('superadmin.event.index', compact('events'));
    }

    public function create()
    {
        return view('superadmin.event.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_event' => 'required|string|max:255',
            'event_start_date' => 'required|date',
            'event_end_date' => 'required|date|after_or_equal:event_start_date',
            'deskripsi' => 'required|string',
            'alamat_event' => 'required|string',
            'image_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lokasi' => 'required|string',
            'tipe_harga' => 'required|in:Gratis,Berbayar',
            'harga' => 'nullable|numeric|min:0',
            'agenda_acara' => 'nullable|array',
            'agenda_acara.*.judul' => 'required|string|max:255',
            'agenda_acara.*.waktu' => 'required|string|max:255',
            'bintang_tamu' => 'nullable|array',
            'bintang_tamu.*' => 'string|max:255',
        ]);

        // Assign data from the request
        $validatedData['nama_event'] = $request->input('nama_event');
        $validatedData['event_start_date'] = $request->input('event_start_date');
        $validatedData['event_end_date'] = $request->input('event_end_date');
        $validatedData['deskripsi'] = $request->input('deskripsi');
        $validatedData['alamat_event'] = $request->input('alamat_event');
        $validatedData['lokasi'] = $request->input('lokasi');
        $validatedData['tipe_harga'] = $request->input('tipe_harga');

        // Set 'harga' to 0 if 'tipe_harga' is 'Gratis'
        $validatedData['harga'] = $request->input('tipe_harga') === 'Gratis' ? 0 : $request->input('harga');

        if ($request->hasFile('image_cover')) {
            $image = $request->file('image_cover');
            $imageName = 'event_cover_' . now()->format('Ymd_His') . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/events'), $imageName);

            $validatedData['image_cover'] = 'assets/images/events/' . $imageName;
        } else {
            $validatedData['image_cover'] = null;
        }


        $validatedData['agenda_acara'] = $request->agenda_acara ? json_encode($request->agenda_acara) : null;
        $validatedData['bintang_tamu'] = $request->bintang_tamu ? json_encode($request->bintang_tamu) : null;

        // Insert the data
        Event::create($validatedData);

        return redirect()->route('event-data')->with('success', 'Event berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $event = Event::findOrFail($id);

        if ($event->agenda_acara) {
            $event->agenda_acara = json_decode($event->agenda_acara, true);
        }

        if ($event->bintang_tamu) {
            $event->bintang_tamu = json_decode($event->bintang_tamu, true);
        }


        return view('superadmin.event.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'event_start_date' => 'required|date',
            'event_end_date' => 'required|date|after_or_equal:event_start_date',
            'deskripsi' => 'required|string',
            'alamat_event' => 'required|string',
            'lokasi' => 'required|string',
            'tipe_harga' => 'required|string',
            'harga' => 'nullable|integer',
            'image_cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'agenda_acara' => 'nullable|array',
            'agenda_acara.*.judul' => 'required|string|max:255',
            'agenda_acara.*.waktu' => 'required|string|max:255',
            'bintang_tamu' => 'nullable|array',
            'bintang_tamu.*' => 'string|max:255',
        ]);

        $event = Event::findOrFail($id);

        $event->nama_event = $request->input('nama_event');
        $event->event_start_date = $request->input('event_start_date');
        $event->event_end_date = $request->input('event_end_date');
        $event->deskripsi = $request->input('deskripsi');
        $event->alamat_event = $request->input('alamat_event');
        $event->lokasi = $request->input('lokasi');
        $event->tipe_harga = $request->input('tipe_harga');

        $event->harga = $request->input('tipe_harga') === 'Gratis' ? 0 : $request->input('harga');

        if ($request->hasFile('image_cover')) {
            if ($event->image_cover && file_exists(public_path($event->image_cover))) {
                unlink(public_path($event->image_cover));
            }

            $image = $request->file('image_cover');
            $imageName = 'event_cover_' . now()->format('Ymd_His') . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/events'), $imageName);

            $event->image_cover = 'assets/images/events/' . $imageName;
        } else {
            $event->image_cover = $event->image_cover ?? null;
        }

        $event->agenda_acara = $request->agenda_acara ? json_encode($request->agenda_acara) : null;
        $event->bintang_tamu = $request->bintang_tamu ? json_encode($request->bintang_tamu) : null;

        $event->save();

        return redirect()->route('event-data')->with('success', 'Event berhasil diperbarui.');
    }



    public function delete($id)
    {
        $event = Event::findOrFail($id);

        if ($event->image_cover && file_exists(public_path('assets/images/events/' . basename($event->image_cover)))) {
            unlink(public_path('assets/images/events/' . basename($event->image_cover)));
        }

        $event->delete();

        return redirect()->route('event-data')->with('success', 'Event berhasil dihapus.');
    }
}

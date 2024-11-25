<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\PesertaEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function show(Request $request)
    {
        $query = Event::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nama_event', 'LIKE', '%' . $search . '%')
                ->orWhere('lokasi', 'LIKE', '%' . $search . '%')
                ->orWhere('tipe_harga', 'LIKE', '%' . $search . '%');
        }

        $events = $query->orderBy('created_at', 'DESC')->paginate(12);

        return view('event.index', compact('events'));
    }

    public function detail($id)
    {
        $event = Event::findOrFail($id);

        if (is_string($event->agenda_acara)) {
            $event->agenda_acara = json_decode($event->agenda_acara, true);
        }

        if (is_string($event->bintang_tamu)) {
            $event->bintang_tamu = json_decode($event->bintang_tamu, true);
        }

        return view('event.detail', compact('event'));
    }

    public function daftar($id)
    {
        $event = Event::findOrFail($id);
        return view('event.daftar', compact('event'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'nama_peserta' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_telepon' => 'nullable|string|max:15',
        ]);

        $event = Event::findOrFail($id);

        $peserta = new PesertaEvent();
        $peserta->event_id = $event->id_event;
        $peserta->nama_peserta = $request->input('nama_peserta');
        $peserta->email = $request->input('email');
        $peserta->no_telepon = $request->input('no_telepon');
        $peserta->amount_paid = $event->harga;
        $peserta->payment_status = 'N';
        $peserta->payment_date = null;
        $peserta->save();

        return redirect()->route('event.detail', ['id' => $event->id_event])
            ->with('success', 'Registration successful. Please proceed with payment.');
    }
}

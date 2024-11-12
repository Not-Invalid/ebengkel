<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function show()
    {
        $events = Event::orderBy('created_at', 'DESC')->paginate(12);
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

}

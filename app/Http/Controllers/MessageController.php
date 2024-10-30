<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendContactMessage(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'telepon' => 'required|string|max:15',
            'pesan' => 'required|string',

        ]);

        Message::create($validate);
        return redirect()->back()->with('status',  'Pesan Anda telah terkirim' );
    }
}

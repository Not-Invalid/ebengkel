<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index()
    {
        $messages = Message::paginate(10);
        return view('superadmin.inbox.index', compact('messages'));
    }
}

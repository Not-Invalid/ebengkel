<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller; // Import the base Controller class
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Set the current page (adjust as needed based on the route)
        $page = 'home'; // or 'event', 'workshop', etc. based on your logic
    
        return view('home', compact('page'));
    }
}

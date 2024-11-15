<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $superadmin = Auth::user();
        return view('superadmin.profile.index', compact('superadmin'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:15',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');

        if ($request->hasFile('foto_profile')) {
            $image = $request->file('foto_profile');

            $imageName = 'foto_admin_' . date('Ymd_His') . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('assets/images/profile_picture'), $imageName);

            $user->foto_profile = url('assets/images/profile_picture/' . $imageName);
        }

        $user->save();

        return redirect()->route('profile-admin', $id)
                        ->with('success', 'Profile updated successfully.');
    }

}

<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::paginate(10);
        return view('superadmin.management-users.data-staff.index', compact('staff'));
    }

    public function create()
    {
        return view('superadmin.management-users.data-staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:15',
            'role' => 'required|string|in:Administrator,User',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('data-staff-admin')->with('status', __('messages-superadmin.toast_superadmin.toast_staff.create'));
    }

    public function edit($id)
    {
        $staff = User::findOrFail($id);
        return view('superadmin.management-users.data-staff.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'required|string|max:15',
            'role' => 'required|string|in:Administrator,User',
        ]);

        $staff = User::findOrFail($id);

        $staff->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'updated_at' => now(),
        ]);

        return redirect()->route('data-staff-admin')->with('status', __('messages-superadmin.toast_superadmin.toast_staff.update'));
    }

    public function delete($id)
    {
        $staff = User::findOrFail($id);

        $staff->delete();

        return redirect()->route('data-staff-admin')->with('status', __('messages-superadmin.toast_superadmin.toast_staff.delete'));
    }
}

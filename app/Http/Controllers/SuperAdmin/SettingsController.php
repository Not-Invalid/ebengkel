<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class SettingsController extends Controller
{
    public function index()
    {
        return view('superadmin.settings.change-password.index');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find(Auth::id());

        if (!$user) {
            return back()->with('status_error', __('messages-superadmin.toast_superadmin.toast_setting.error_user'));
        }

        if (!password_verify($request->input('currentPassword'), $user->password)) {
            return back()->with('status_error', __('messages-superadmin.toast_superadmin.toast_setting.error_pw'));
        }

        $user->update([
            'password' => Hash::make($request->input('newPassword')),
        ]);

        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login-admin')->with('status', __('messages-superadmin.toast_superadmin.toast_setting.succes_pw'));
    }

    public function language()
    {
        return view('superadmin.settings.language-setting.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $users = User::orderBy('name')->pluck('name', 'id');
        return view('auth.login', compact('users'));
    }

    /**
     * Handle login attempt.
     */
    public function login(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required',
        ], [
            'user_id.required' => 'Pilih pengguna.',
            'user_id.exists' => 'Pengguna tidak ditemukan.',
            'password.required' => 'Password harus diisi.',
        ]);

        $user = User::find($request->user_id);

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'password' => 'Password salah.',
        ])->withInput();
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /**
     * Show change password form.
     */
    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    /**
     * Handle password change.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:4|confirmed',
        ], [
            'current_password.required' => 'Password lama harus diisi.',
            'new_password.required' => 'Password baru harus diisi.',
            'new_password.min' => 'Password baru minimal 4 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama salah.',
            ]);
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('dashboard')->with('success', 'Password berhasil diubah!');
    }
}

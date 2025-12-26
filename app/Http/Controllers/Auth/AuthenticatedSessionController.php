<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Cek Role User yang baru login
        $role = $request->user()->role;

        // 1. Jika Pasien -> Landing Page Pasien
        if ($role === 'pasien') {
            return redirect()->route('pasiens.landingpage');
        }

        // 2. Jika Admin -> Dashboard Admin
        if ($role === 'admin') {
            return redirect()->intended(route('admindashboard', absolute: false));
        }

        // 3. Jika Dokter -> Dashboard Dokter
        if ($role === 'dokter') {
            return redirect()->intended(route('dokterdashboard', absolute: false));
        }

        // Default redirect jika tidak ada role yang cocok (opsional)
        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

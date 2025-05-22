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
    // Proses autentikasi user
    $request->authenticate();

    // Regenerate session untuk keamanan setelah login
    $request->session()->regenerate();

    // Ambil data user yang baru login
    $user = Auth::user();

    // Redirect sesuai role user
    if ($user->role === 'admin') {
        // Kalau admin, arahkan ke dashboard admin
        return redirect()->route('admin.dashboard');
    }

    // Kalau bukan admin, misal user biasa
    return redirect()->route('dashboard'); // route untuk user biasa
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

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

        $user = Auth::user();

        // Se utente business non approvato, logout e redirect
        if ($user->role === 'business' && $user->status == 0) {
            Auth::logout();
            return redirect()->route('business.pending');
        }

        // Redirect in base al ruolo
        switch ($user->role) {
            case 'admin':
            case 'superadmin':
                return redirect()->intended(route('dashboard', absolute: false));

            case 'business':
                return redirect()->intended(route('business.dashboard', absolute: false));

            case 'user':
            default:
                return redirect()->intended(route('user.dashboard', absolute: false));
        }
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

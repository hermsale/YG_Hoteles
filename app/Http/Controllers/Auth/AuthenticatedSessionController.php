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
     * este metodo controla el login y su redirect
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // capturo el usuario logiado
        $user = Auth::user();

        // Redirección personalizada - si es administrador
        if ($user->rol->nombre_rol === 'Administrador') {
            return redirect()->intended('/dashboard');
        }

        // Redirección personalizada - si es cliente
        if ($user->rol->nombre_rol === 'Cliente') {
            return redirect()->intended('/');
        }

        // Redirección por defecto
        return redirect()->intended('/');
        // return redirect()->intended(route('dashboard', absolute: false));
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

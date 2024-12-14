<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
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

        $appointment = DB::table('user_appointments')
        ->where('userId', Auth::id())
        ->where('current', 1)
        ->where('active', 1)
        ->value('id', 'monasteryId');

        $appointmentId = $appointment->id ?? null; // Handle null if no match
        $monasteryId = $appointment->monasteryId ?? null;

        $positionId = DB::table('appointment_positions')
        ->where('appointmentId', $appointmentId)
        ->where('current', 1)
        ->where('active', 1)
        ->first(['positionId']);

        session(['appointmentId' => $appointmentId]);
        session(['monasteryId' => $monasteryId]);
        session(['positionId' => $positionId]);

        return redirect()->intended(RouteServiceProvider::HOME);
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

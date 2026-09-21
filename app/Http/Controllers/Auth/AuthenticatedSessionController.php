<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Periode;
use App\Traits\LogsActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    use LogsActivity;
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

        $this->log('login', 'Login: '.Auth::user()?->name.' ('.Auth::user()?->role.')');

        // Flag popup naik kelas untuk siswa di periode beda
        $user = Auth::user();
        if ($user->isSiswa()) {
            $siswa = $user->siswa;
            $periodeAktif = Periode::where('aktif', true)->first();
            if ($siswa && $periodeAktif && $siswa->periode_terakhir_ikuti !== $periodeAktif->id) {
                Session::flash('show_naik_kelas', true);
            }
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}

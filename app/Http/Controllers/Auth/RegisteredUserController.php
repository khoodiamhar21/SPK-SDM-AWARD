<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $kelas = \App\Models\Kelas::orderBy('urutan')->get();

        return view('auth.register', compact('kelas'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nisn' => ['required', 'string', 'max:30'],
            'name' => ['required', 'string', 'max:255'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $master = Siswa::where('nisn', $request->nisn)->first();

        if (! $master) {
            throw ValidationException::withMessages([
                'nisn' => 'NISN belum terdaftar. Hubungi Panitia untuk didaftarkan.',
            ]);
        }

        if (strcasecmp($master->nama, $request->name) !== 0) {
            throw ValidationException::withMessages([
                'name' => 'Nama tidak cocok dengan data NISN tersebut.',
            ]);
        }

        if ($master->kelas_id != $request->kelas_id) {
            throw ValidationException::withMessages([
                'kelas_id' => 'Kelas tidak cocok dengan data NISN tersebut.',
            ]);
        }

        if ($master->user_id) {
            throw ValidationException::withMessages([
                'nisn' => 'NISN ini sudah memiliki akun.',
            ]);
        }

        $user = User::create([
            'name' => $master->nama,
            'email' => 'siswa'.time().'@sdmaward.local',
            'nisn' => $request->nisn,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        $periodeAktif = Periode::where('aktif', true)->first();
        $master->update([
            'user_id' => $user->id,
            'waktu_registrasi_pertama' => now(),
            'periode_terakhir_ikuti' => $periodeAktif?->id,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

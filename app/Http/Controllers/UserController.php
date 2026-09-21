<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserController extends Controller
{
    use LogsActivity;
    public function index()
    {
        $users = User::orderBy('role')->orderBy('name')->get();
        return view('panel.akun-index', compact('users'));
    }

    public function create()
    {
        return view('panel.akun-form', ['user' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->letters()->mixedCase()->numbers()],
            'role' => ['required', 'in:panitia,validator,wakasiswa,siswa'],
        ]);

        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->role = $data['role'];
        $user->save();

        $this->log('create_user', "Buat akun {$data['role']}: {$data['name']} ({$data['email']})", $user);

        return redirect()->route('panel.akun.index')->with('status', 'Akun berhasil dibuat.');
    }

    public function edit(User $user)
    {
        return view('panel.akun-form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::min(8)->letters()->mixedCase()->numbers()],
            'role' => ['required', 'in:panitia,validator,wakasiswa,siswa'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        $this->log('update_user', "Update akun {$data['role']}: {$data['name']} ({$data['email']})", $user);

        return redirect()->route('panel.akun.index')->with('status', 'Akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['msg' => 'Tidak bisa menghapus akun sendiri.']);
        }

        $this->log('delete_user', "Hapus akun {$user->role}: {$user->name} ({$user->email})", $user);

        $user->delete();

        return redirect()->route('panel.akun.index')->with('status', 'Akun dihapus.');
    }
}

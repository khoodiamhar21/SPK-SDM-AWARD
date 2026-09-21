<?php

namespace App\Http\Requests\Auth;

use App\Models\ActivityLog;
use App\Models\Siswa;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'credential' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credential = $this->string('credential')->toString();
        $password = $this->string('password')->toString();

        if (! str_contains($credential, '@')) {
            $this->authenticateSiswa($credential, $password);

            return;
        }

        if (! Auth::attempt(['email' => $credential, 'password' => $password], $this->boolean('remember'))) {
            $this->failedLogin($credential);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Login siswa menggunakan NIS (di data siswa), tanpa register.
     */
    protected function authenticateSiswa(string $nis, string $password): void
    {
        $siswa = Siswa::where('nisn', $nis)->first();

        if (! $siswa) {
            $this->failedLogin($nis);

            return;
        }

        $user = $this->ensureUser($siswa);

        if (! Auth::attempt(['id' => $user->id, 'password' => $password], $this->boolean('remember'))) {
            $this->failedLogin($nis);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Pastikan setiap siswa memiliki akun User (username & password = NIS).
     */
    protected function ensureUser(Siswa $siswa)
    {
        $user = $siswa->user_id ? \App\Models\User::find($siswa->user_id) : null;

        if (! $user) {
            $user = new \App\Models\User([
                'name' => $siswa->nama,
                'email' => ($siswa->nisn ?? 'siswa'.$siswa->id).'@sdmaward.local',
                'nisn' => $siswa->nisn,
                'password' => $siswa->nisn,
            ]);
            $user->role = 'siswa';
            $user->save();
            $siswa->update(['user_id' => $user->id]);
        }

        return $user;
    }

    protected function failedLogin(string $credential, string $message = 'auth.failed'): never
    {
        RateLimiter::hit($this->throttleKey());

        ActivityLog::create([
            'action' => 'login_gagal',
            'description' => "Login gagal: {$credential} (".($message === 'auth.failed' ? 'kredensial salah' : $message).')',
            'ip' => $this->ip(),
        ]);

        throw ValidationException::withMessages([
            'credential' => $message === 'auth.failed' ? trans('auth.failed') : $message,
        ]);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'credential' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('credential')).'|'.$this->ip());
    }
}

<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {

            // 👇 Log login fallido
            DB::table('logs_sesiones')->insert([
                'usuario'     => null,
                'email'       => $this->email,
                'accion'      => 'login_fallido',
                'ip'          => $this->ip(),
                'dispositivo' => $this->userAgent(),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // 👇 Log login exitoso
        DB::table('logs_sesiones')->insert([
            'usuario'     => Auth::user()->name,
            'email'       => Auth::user()->email,
            'accion'      => 'login_exitoso',
            'ip'          => $this->ip(),
            'dispositivo' => $this->userAgent(),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        RateLimiter::resetAttempts($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
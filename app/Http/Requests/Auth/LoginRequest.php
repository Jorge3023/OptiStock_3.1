<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /*Determine if the user is authorized to make this request.*/
    public function authorize(): bool
    {
        return true;
    }

/*Reglas de validación*/
public function rules(): array
{
    return [
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string'],
    ];
}

/* Intentar autenticar */
public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $user = User::where('email', $this->input('email'))->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // bloqueo manual por administrador
        if ($user->is_blocked) {
            throw ValidationException::withMessages([
                'email' => 'Esta cuenta ha sido bloqueada por un administrador.',
            ]);
        }

        // bloqueo temporal
        if ($user->lock_until && Carbon::now()->lt($user->lock_until)) {
            $minutes = ceil(Carbon::now()->diffInSeconds($user->lock_until) / 60);

            throw ValidationException::withMessages([
                'email' => "Cuenta bloqueada temporalmente. Intenta nuevamente en $minutes minutos.",
            ]);
        }

        // verificar credenciales
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {

            $user->login_attempts++;

            // si llega a 3 intentos fallidos
            if ($user->login_attempts >= 3) {

                $user->lock_until = Carbon::now()->addMinutes(10);
                $user->login_attempts = 0;
            }

            $user->save();

            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // login correcto
        RateLimiter::clear($this->throttleKey());

        $user->login_attempts = 0;
        $user->lock_until = null;
        $user->save();
    }

    /**
     * Verificar rate limit
     */
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

    /**
     * Clave para rate limit
     */
        public function throttleKey(): string
        {
            return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
        }
    }
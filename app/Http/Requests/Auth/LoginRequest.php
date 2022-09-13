<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;


/**
 * @bodyParam   login    string  required    Username or email adress of the user.      Exemple: testuser@example.com, user123
 * @bodyParam   password    string  required    The password of the  user.   Example: secret
 */
class LoginRequest extends FormRequest
{
    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
        return true;
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        return [
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => "Email ou nom d'utilisateur obligatoire",
            'email.string' => "Email ou nom d'utilisateur non valide",
            'password.required' => "Mot de passe obligatoire",
            'password.string' => "Mot de passe non valide",
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     * @return void
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        $user = User::where('email', $this->email)
            ->orWhere('username', $this->email)
            ->first();

        if (!$user || Crypt::decrypt($user->password) !== $this->password) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => "Adresse email / Nom d'utilisateur ou mot de passe incorrecte",
            ]);
        }

        Auth::login($user, $this->boolean('remember'));
        RateLimiter::clear($this->throttleKey());
    }

    /**
    * Ensure the login request is not rate limited.
    *
    * @return void
    *
    * @throws \Illuminate\Validation\ValidationException
    */
    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
    * Get the rate limiting throttle key for the request.
    *
    * @return string
    */
    public function throttleKey()
    {
        return Str::lower($this->input('login')) . '|' . $this->ip();
    }

    public function bodyParameters()
    {
        return [

        ];
    }
}



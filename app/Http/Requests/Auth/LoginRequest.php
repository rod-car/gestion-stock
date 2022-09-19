<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;


/**
 * @bodyParam   email    string  required    Nom d'utilisateur ou adresse email.      Exemple: user@example.com, user123
 * @bodyParam   password    string  required    Mot de passe.   Example: secret
 */
class LoginRequest extends FormRequest
{
    /**
    * Permet de savoir si l'utilisateur est autorisé a faire la requête
    *
    * @return bool
    */
    public function authorize()
    {
        return true;
    }

    /**
    * Règles de validation.
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
     * Message d'erreurs en cas de faillure.
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
     * Uthentifie l'utilisateur.
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

            throw new HttpResponseException(
                response()->json(
                    [
                        'message' => 'Les données sont invalides',
                        'errors' => [
                            'login' => "Adresse email / Nom d'utilisateur ou mot de passe incorrecte",
                        ]
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                )
            );
        }

        Auth::login($user, $this->boolean('remember'));
        RateLimiter::clear($this->throttleKey());
    }

    /**
    * Verifier la limite de tentative de connexion fait par l'utilisateur.
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
     * Determiner la limitation de tentative de connexion.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('login')) . '|' . $this->ip();
    }

    public function bodyParameters()
    {
        return [];
    }
}



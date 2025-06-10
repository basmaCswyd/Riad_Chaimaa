<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    // On ajoute nos règles de validation pour les nouveaux champs
    $request->validate([
        'prenom' => ['required', 'string', 'max:255'],
        'nom' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'num_telephone' => ['required', 'string', 'max:20', 'unique:'.User::class],
        'annee_naissance' => ['required', 'integer', 'min:1920', 'max:'.date('Y')],
        'cin' => ['required', 'string', 'max:20', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // On crée l'utilisateur avec tous les champs
    $user = User::create([
        'prenom' => $request->prenom,
        'nom' => $request->nom,
        'email' => $request->email,
        'num_telephone' => $request->num_telephone,
        'annee_naissance' => $request->annee_naissance,
        'cin' => $request->cin,
        'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    Auth::login($user);

    // Redirige vers la page d'accueil après inscription
    return redirect(route('home', absolute: false));
}
}

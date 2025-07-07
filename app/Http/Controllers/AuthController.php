<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Str;

class AuthController extends Controller
{
    // Redirection vers la page Login
    public function getLogin()
    {
        // dd($request->validated());
        return view('auth.login-page');
    }

    // Redirection vers la page Sign Up
    public function getSignup()
    {
        return view('auth.signup-page');
    }

    // Inscription
    public function signup(SignupRequest $request)
    {
        // Génération du username
        $username = strtolower($request->input('firstname') . $request->input('lastname'));
        $baseUsername = $username;
        $suffix = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $suffix;
            $suffix++;
        }

        // Création de l'utilisateur
        $user = new User();
        $user->first_name = $request->input('firstname');
        $user->last_name = $request->input('lastname');
        $user->username = $username;
        $user->email = $request->input('email');
        $user->role = 1;
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Connexion automatique
        Auth::login($user, false);

        // Redirection avec popup de confirmation
        return redirect()->route('home')->with('popup_type', 'congrats');
    }


    public function login(LoginRequest $request)
    {
        // 1. Récupération des données
        $login = $request->input('login'); // Peut être un username ou un email
        $password = $request->input('password');
        $remember = $request->has('remember');

        // 2. Détection du champ à utiliser
        $user = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $login)->first()
            : User::where('username', $login)->first();

        // 3. Vérification de l'utilisateur et du mot de passe
        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $remember);
            $request->session()->regenerate();

            return redirect()->intended('/')->with('popup_type', 'congrats');
        }

        // 4. Échec d'authentification
        return back()->with('type', 'danger')->with('content', 'Les informations de connexion fournies sont incorrectes. Veuillez réessayer.');
    }


    // Déconnexion
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

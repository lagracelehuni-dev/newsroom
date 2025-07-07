<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    // Affiche le formulaire
    public function showResetForm()
    {
        return view('auth.password.reset');
    }

    // Met à jour le mot de passe
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = Auth::user();

        // Vérifie le mot de passe actuel
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect.']);
        }

        // Met à jour
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('home')
            ->with('type', 'success')
            ->with('content', 'Votre mot de passe a été mis à jour avec succès.');
    }

    /**
     * Affiche la page de demande de réinitialisation.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.password.forgot');
    }

    /**
     * Envoie le code de réinitialisation au mail fourni.
     */
    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('type', 'error')
                ->with('content', 'Veuillez fournir un email valide.');
        }

        $email = $request->email;

        // Vérifie si une réinitialisation a été faite il y a moins de 48h
        $lastResetKey = 'last_reset_' . $email;
        if (Cache::has($lastResetKey)) {
            return back()
                ->with('type', 'error')
                ->with('content', 'Vous devez attendre 48h avant de faire une autre réinitialisation de mot de passe.');
        }

        // Génération d’un code à 6 chiffres
        $code = rand(100000, 999999);

        // Stocker temporairement le code dans le cache pour 15 min
        Cache::put('reset_code_' . $email, $code, now()->addMinutes(15));

        // Simuler l’envoi par email (à remplacer par ton système d’email réel)
        Mail::raw("Votre code de réinitialisation est : $code", function ($message) use ($email) {
            $message->to($email)->subject('Code de réinitialisation');
        });

        return redirect()->route('auth.password.verify-code')->with('email', $email);
    }
}


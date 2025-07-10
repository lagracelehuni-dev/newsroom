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

    /**
     * Met à jour le mot de passe de l'utilisateur connecté.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Validation des champs
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'min:6']
        ],
        [
            'current_password.required' => 'Veuillez renseigner ce champ',
            'password.required' => 'Veuillez renseigner le champ *Mot de passe',
            'password.min' => 'Le mot de passe doit contenir au-moins 6 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password_confirmation.required' => 'Veuillez confirmer votre mot de passe',
            'password_confirmation.min' => 'Le mot de passe doit contenir au-moins 6 caractères'

        ]);

        // Vérifie si le mot de passe actuel est correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with([
                'type' => 'danger',
                'content' => 'Le mot de passe actuel est incorrect.'
            ]);
        }

        // Vérifie si le nouveau mot de passe est différent de l'ancien
        if (Hash::check($request->password, $user->password)) {
            return back()->with([
                'type' => 'danger',
                'content' => 'Le nouveau mot de passe doit être différent de l\'ancien.'
            ]);
        }

        // Mise à jour du mot de passe
        $user->password = $request->password;
        $user->last_password_reset_at = now(); // suivi du reset
        $user->save();

        // (Optionnel) Déconnecter l'utilisateur après reset
        // Auth::logout();

        return redirect()->route('home')
            ->with('type', 'success')
            ->with('content', 'Votre mot de passe a été mis à jour avec succès.');
    }

    // Affiche le formulaire de forgot
    public function showForgotPasswordForm()
    {
        return view('auth.password.forgot');
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Affiche le formulaire de suppression du compte
     */
    public function showDeleteForm()
    {
        // Attribuer une session temporaire pour sécuriser l’accès à la page de suppression
        session(['can_delete_account' => true]);

        return view('auth.delete-account');
    }

    public function confirmDeletionIntent()
    {
        session(['can_delete_account' => true]);
        return redirect()->route('account.delete');
    }


    /**
     * Supprime définitivement le compte après vérification du mot de passe
     */
    public function destroy(Request $request)
    {
        // Validation du mot de passe actuel
        $request->validate([
            'password' => ['required'],
        ],
        [
            'password.required' => 'Le mot de passe est requis.',
        ]);

        $user = Auth::user();

        // Vérification que le mot de passe fourni est correct
        if (!Hash::check($request->password, $user->password)) {
            return back()->with([
                'type' => 'danger',
                'content' => 'Mot de passe incorrect. Suppression annulée.',
            ]);
        }

        // Déconnexion et suppression du compte
        Auth::logout();

        // Suppression des données de session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Suppression de l’utilisateur
        $user->delete();

        return redirect('/');
    }
}

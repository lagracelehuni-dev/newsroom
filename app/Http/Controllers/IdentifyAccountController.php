<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class IdentifyAccountController extends Controller
{
     /**
     * Affiche le formulaire de recherche de compte.
     */
    public function showForm()
    {
        return view('auth.password.identify-account');
    }

    /**
     * Traite la recherche du compte par email.
     */
    public function search(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Veuillez entrer une adresse email.',
            'email.email' => 'Le format de l\'email est invalide.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with([
                'type' => 'danger',
                'content' => 'Aucun compte ne correspond à cet email.'
            ])->withInput();
        }

        // Mettre les infos utiles en session
        session([
            'user_found' => true,
            'user_email' => $user->email,
            'user_username' => $user->username,
            'user_avatar' => $user->avatar ? asset($user->avatar) : asset( 'storage/avatars/default_avatar.jpg'),
        ]);

        return back()
            ->with('type', 'info')
            ->with('content', 'Compte trouvé.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
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

        // Générer un token temporaire sécurisé
        $token = Str::random(64);
        $expiresAt = Carbon::now()->addMinutes(30); // Token valide 30 minutes

        // Supprimer les anciens tokens pour cet email
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        // Stocker le nouveau token
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => Carbon::now(),
            'expires_at' => $expiresAt,
        ]);

        // Mettre les infos utiles en session (pour compatibilité)
        session([
            'user_found' => true,
            'user_email' => $user->email,
            'email' => $user->email,
            'user_username' => $user->username,
            'user_avatar' => $user->avatar ? asset($user->avatar) : asset( 'storage/avatars/default_avatar.jpg'),
        ]);
        
        // Forcer la sauvegarde de la session
        session()->save();

        return back()
            ->with('type', 'info')
            ->with('content', 'Compte trouvé.')
            ->with('reset_token', $token); // Passer le token à la vue
    }
}

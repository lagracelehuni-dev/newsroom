<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{

    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ],
        [
            'email.required' => 'Veuillez renseigner le champ *Email',
            'email.email' => 'Email invalide',
            'email.exists' => 'Aucun compte n’est lié à cette adresse.',
        ]);

        $user = User::where('email', $request->email)->first();

        // Générer un code aléatoire (6 chiffres)
        $code = random_int(100000, 999999);

        // Supprimer les anciens codes si existants
        DB::table('password_resets')->where('email', $user->email)->delete();

        // Stocker le nouveau code
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $code, // ici on stocke directement le code, pas un hash
            'created_at' => Carbon::now(),
        ]);

        // Envoyer le code par email
        Mail::to($user->email)->send(new PasswordResetCodeMail($code));

        // Stocker l’email dans la session pour sécuriser la prochaine étape
        session([
            'email' => $user->email,
        ]);


        return redirect()->route('password.verifycode.form')
            ->with('email', $user->email)
            ->with('type', 'info')
            ->with('content', 'Un code de réinitialisation vous a été envoyé par email.');
    }

    /**
     * Traite la soumission du code + nouveau mot de passe.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'code' => ['required', 'digits:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],
        [
            'email.required' => 'Veuillez entrer votre adresse email.',
            'email.email' => 'Le format de l\'email est invalide.',
            'email.exists' => 'Aucun utilisateur ne correspond à cet email.',

            'code.required' => 'Le code de vérification est requis.',
            'code.digits' => 'Le code doit contenir exactement 6 chiffres.',

            'password.required' => 'Veuillez entrer un nouveau mot de passe.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        // Récupérer le reset
        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        // Vérification du code
        if (!$reset) {
            return back()->with([
                'type' => 'danger',
                'content' => 'Le code est invalide ou a expiré.'
            ]);
        }

        // Vérifier l’expiration (15 minutes par défaut)
        $expiresAt = Carbon::parse($reset->created_at)->addMinutes(15);
        if (now()->gt($expiresAt)) {
            // Supprimer le code expiré
            DB::table('password_resets')->where('email', $request->email)->delete();
            return back()->with([
                'type' => 'danger',
                'content' => 'Le code a expiré. Veuillez refaire une demande.'
            ]);
        }

        // Mise à jour du mot de passe
        $user = User::where('email', $request->email)->first();
        $user->password = $request->password;
        $user->last_password_reset_at = now();
        $user->save();

        // Supprimer le code après usage
        DB::table('password_resets')->where('email', $request->email)->delete();

        // Connexion automatique (optionnel)
        Auth::login($user);

        return redirect()->route('home')
            ->with('type', 'success')
            ->with('content', 'Mot de passe réinitialisé avec succès.');
    }

    public function sendResetCodeAfterIdentification(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'L’adresse email est requise.',
            'email.email' => 'Le format de l’email est invalide.',
            'email.exists' => 'Aucun compte n’est lié à cette adresse.',
        ]);

        $user = User::where('email', $request->email)->first();

        // Générer un code à 6 chiffres
        $code = random_int(100000, 999999);

        // Supprimer les anciens codes pour cet email
        DB::table('password_resets')->where('email', $user->email)->delete();

        // Stocker le nouveau code
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $code,
            'created_at' => now(),
        ]);

        // Envoyer l’email
        Mail::to($user->email)->send(new \App\Mail\PasswordResetCodeMail($code));

        // Stocker l’email dans la session pour sécuriser la prochaine étape
        session([
            'email' => $user->email,
        ]);

        // Nettoyage des données de session temporaires
        session()->forget(['user_found', 'user_username', 'user_email', 'user_avatar']);

        // Redirection vers le formulaire de saisie du code
        return redirect()->route('password.verifycode.form')
            ->with('email', $user->email)
            ->with('type', 'info')
            ->with('content', 'Un code de réinitialisation vous a été envoyé par email.');
    }
}

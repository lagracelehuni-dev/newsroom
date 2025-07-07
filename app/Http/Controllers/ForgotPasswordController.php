<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // 1. Affiche le formulaire de demande d’email
    public function showEmailForm()
    {
        return view('auth.password.email');
    }

    // 2. Envoie du code de réinitialisation par email
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Vérifier le délai de 48h
        if ($user->last_password_reset_at && now()->diffInHours($user->last_password_reset_at) < 48) {
            $remaining = 48 - now()->diffInHours($user->last_password_reset_at);
            return back()->with('error', "Veuillez attendre encore $remaining heure(s) avant une nouvelle tentative.");
        }

        $code = random_int(100000, 999999);

        // Stocker le code et l'email en session
        Session::put('password_reset_code', (string)$code);
        Session::put('password_reset_email', $user->email);

        // Envoyer l'email
        Mail::raw("Voici votre code de réinitialisation : $code", function ($message) use ($user) {
            $message->to($user->email)
                ->subject("Code de réinitialisation de mot de passe");
        });

        return redirect()->route('password.verify.form', ['email' => $user->email])
            ->with('type', '')
            ->with('content', 'Un code de réinitialisation a été envoyé à votre adresse email.');
    }

    // 3. Affiche le formulaire pour entrer le code
    public function showVerificationForm(Request $request)
    {
        return view('auth.password.verify-code', [
            'email' => $request->email
        ]);
    }

    // 4. Vérifie le code soumis par l’utilisateur
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string',
        ]);

        $storedCode = Session::get('password_reset_code');
        $storedEmail = Session::get('password_reset_email');

        if (!$storedCode || !$storedEmail) {
            return back()->with('error', 'Le code a expiré ou est invalide. Veuillez recommencer.');
        }

        if ($storedEmail !== $request->email || $storedCode !== $request->code) {
            return back()->with('error', 'Code incorrect ou email non reconnu.');
        }

        return redirect()->route('password.reset.form')->with('email', $request->email);
    }

    // 5. Affiche le formulaire pour entrer le nouveau mot de passe
    public function showNewPasswordForm()
    {
        $email = session('email');

        if (!$email) {
            return redirect()->route('password.email')->with('error', 'Session expirée. Veuillez recommencer.');
        }

        return view('auth.passwords.new-password', compact('email'));
    }

    // 6. Met à jour le mot de passe
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|confirmed|min:6',
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        $user->password = Hash::make($request->password);
        $user->last_password_reset_at = Carbon::now(); // Ajoute cette colonne dans la table users
        $user->save();

        // Suppression des sessions sensibles
        Session::forget('password_reset_code');
        Session::forget('password_reset_email');
        Session::forget('email');

        return redirect()->route('login')->with([
            'type' => 'success',
            'content' => 'Mot de passe mis à jour avec succès. Vous pouvez maintenant vous connecter.'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfilRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditProfilController extends Controller
{
    //

    public function editProfil($username)
    {
        // Bloquer l'accès si la modification vient d'être faite
        // if (session('profil_edit_done')) {
        //     return redirect()->route('profil', ['username' => Auth::user()->username]);
        // }
        $user = User::where('username', $username)->firstOrFail();

        return view('main.master-main', compact('user'));
    }

    public function updateProfil(UpdateProfilRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $data = $request->validated();

        // Gestion de l'upload de l'avatar
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            // Supprimer l'ancien avatar si besoin (optionnel)
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = 'storage/' . $path;
        }

        $user->update($data);

        // Empêcher le retour vers editprofil après la mise à jour
        // On supprime l'URL précédente de la session pour éviter le retour avec le bouton "retour"
        // session()->forget('url.intended');
        // On peut aussi ajouter un flag pour désactiver l'accès à editprofil
        // session(['profil_edit_done' => false]);

        return redirect()->route('profil', ['username' => $user->username])
            ->with('type', 'success')
            ->with('content', 'Profil mis à jour avec succès.');
    }
}

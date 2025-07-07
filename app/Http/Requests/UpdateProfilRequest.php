<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfilRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Autorise tous les utilisateurs connectés
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'username' => 'required|string|max:30|alpha_dash|unique:users,username,' . $this->user()->id,
            'email' => 'required|email|max:255|unique:users,email,' . $this->user()->id,
            'bio' => 'nullable|string|max:160',
            'location' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'avatar__input' => 'nullable|image|mimes:jpeg|max:2048', // 2MB max
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Veuillez renseigner le champ *Prénom',
            'first_name.max' => 'Le prénom ne peut pas dépasser 30 caractères',
            'last_name.required' => 'Veuillez renseigner le champ *Nom',
            'last_name.max' => 'Le nom ne peut pas dépasser 30 caractères',
            'username.required' => 'Veuillez renseigner le champ *Nom d\'utilisateur',
            'username.max' => 'Le nom d\'utilisateur ne peut pas dépasser 30 caractères',
            'username.alpha_dash' => 'Le nom d\'utilisateur ne peut contenir que des lettres, des chiffres, des tirets et des tirets bas',
            'username.unique' => 'Le nom d\'utilisateur est déjà pris',
            'email.required' => 'Veuillez renseigner le champ *Email',
            'email.email' => 'Email invalide',
            'email.unique' => 'Email déjà existant',
            'bio.max' => 'La biographie ne peut pas dépasser 160 caractères',
            'location.max' => 'La localisation ne peut pas dépasser 50 caractères',
            'website.url' => 'Le site web doit être une URL valide',
            'avatar__input.image' => 'L\'avatar doit être une image valide (JPEG)',
            'avatar__input.mimes' => 'L\'avatar doit être au format JPEG',
            'avatar__input.max' => 'L\'avatar ne peut pas dépasser 2MB',
        ];
    }

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;
}

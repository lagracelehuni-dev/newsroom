<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'bail|required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'firstname.bail' => 'Veuillez renseigner le champ *Prénom',
            'firstname.required' => 'Veuillez renseigner le champ *Prénom',
            'lastname.required' => 'Veuillez renseigner le champ *Nom',
            'email.required' => 'Veuillez renseigner le champ *Email',
            'email.email' => 'Email invalide',
            'email.unique' => 'Email déjà existant',
            'password.required' => 'Veuillez renseigner le champ *Mot de passe',
            'password.min' => 'Le mot de passe doit contenir au-moins 6 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password_confirmation.required' => 'Veuillez confirmer votre mot de passe',
            'password_confirmation.min' => 'Le mot de passe doit contenir au-moins 6 caractères'
        ];
    }

    /**
     * Indicates if the validator should stop on the first rulefaillure
     * 
     * @var bool
     */
    protected $stopOnFirstFailure = true;
}

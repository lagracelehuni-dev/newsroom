<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'login' => [
                'required',
            ],
            'password' => [
                'required',
                'min:6',
                'max:100',
            ],
        ];
    }

    /**
     * Messages d'erreur personnalisés.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'login.required' => 'Veuillez entrer un nom d’utilisateur ou un email.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
            'password.max' => 'Le mot de passe ne doit pas dépasser :max caractères.',
        ];
    }

    /**
     * Indicates if the validator should stop on the first rulefaillure
     * 
     * @var bool
     */
    protected $stopOnFirstFailure = true;
}

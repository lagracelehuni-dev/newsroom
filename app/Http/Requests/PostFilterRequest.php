<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostFilterRequest extends FormRequest
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
            'compose__title' => 'required|string|max:80',
            'compose__slug' => 'required_unless:compose__custom-slug,on|string|max:80|unique:posts,slug',
            'compose__content' => 'required|string|min:10',
            // La catégorie est requise seulement si aucune nouvelle catégorie n'est saisie
            'compose__category' => 'required_without:compose__new-category|exists:categories,id',
            'compose__new-category' => 'nullable|string|max:50',
            // Le temps de lecture est requis sauf si la case temps de lecture automatique est cochée
            'compose__reading-time' => 'required_unless:compose__custome-reading-time,on|integer|min:1|max:60',
            'compose__cover-image' => 'nullable|image|mimes:jpeg,jpg|max:2048',
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
            // Vous pouvez ajouter des messages d'erreur personnalisés ici si nécessaire
            'compose__title.required' => 'Le titre est obligatoire.',
            'compose__title.max' => 'Le titre ne peut pas dépasser 80 caractères.',
            'compose__slug.required_unless' => 'Le slug est obligatoire.',
            'compose__slug.max' => 'Le slug ne peut pas dépasser 80 caractères.',
            'compose__slug.unique' => 'Ce slug existe déjà. Le slug doit être unique.',
            'compose__content.required' => 'Le contenu est obligatoire.',
            'compose__content.min' => 'Le contenu doit contenir au moins 10 caractères.',
            'compose__category.required_without' => 'La catégorie est obligatoire si aucune nouvelle catégorie n\'est saisie.',
            'compose__category.exists' => 'La catégorie sélectionnée n\'existe pas.',
            'compose__new-category.string' => 'La nouvelle catégorie doit être une chaîne de caractères.',
            'compose__new-category.max' => 'La nouvelle catégorie ne peut pas dépasser 50 caractères.',
            'compose__reading-time.required_unless' => 'Le temps de lecture est obligatoire.',
            'compose__reading-time.integer' => 'Le temps de lecture doit être un nombre entier.',
            'compose__reading-time.min' => 'Le temps de lecture doit être d\'au moins 1 minute.',
            'compose__reading-time.max' => 'Le temps de lecture ne peut pas dépasser 60 minutes.',
            'compose__cover-image.image' => 'Le fichier doit être une image.',
            'compose__cover-image.mimes' => 'L\'image doit être au format jpeg ou jpg.',
            'compose__cover-image.max' => 'L\'image ne peut pas dépasser 2 Mo.',
        ];
    }

    /**
     * Indicates if the validator should stop on the first rulefaillure
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;
}

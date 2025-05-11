<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoryRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Par défaut, l'autorisation est définie sur "false"
    
        return false;
    }

    /**
     * Récupère les règles de validation qui s'appliquent à la requête.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Le titre de l'histoire est facultatif (sometimes)
            // S'il est présent, il doit être non vide, de type chaîne et avec un maximum de 255 caractères
            'title' => 'sometimes|required|string|max:255',

            // La description de l'histoire est facultative (nullable)
            // Si elle est présente, elle doit être une chaîne de caractères
            'description' => 'nullable|string',
        ];
    }
}

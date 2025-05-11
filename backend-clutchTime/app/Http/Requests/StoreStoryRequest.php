<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoryRequest extends FormRequest
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
            // L'identifiant de l'histoire est requis et doit exister dans la table "stories"
            'story_id' => 'required|exists:stories,id',

            // Le titre de l'histoire est obligatoire, doit être une chaîne de caractères et avoir au maximum 255 caractères
            'title' => 'required|string|max:255',

            // Le contenu de l'histoire est obligatoire et doit être une chaîne de caractères
            'content' => 'required|string',

            // Le champ "is_start" est facultatif et doit être un booléen s'il est présent
            'is_start' => 'boolean',
        ];
    }
}

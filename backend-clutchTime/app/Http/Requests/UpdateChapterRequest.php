<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChapterRequest extends FormRequest
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
            // L'identifiant de l'histoire est facultatif (sometimes) mais doit exister dans la table "stories" s'il est présent
            'story_id' => 'sometimes|exists:stories,id',

            // Le titre est facultatif (sometimes), mais s'il est présent, il doit être non vide, de type chaîne et avec un maximum de 255 caractères
            'title' => 'sometimes|required|string|max:255',

            // Le contenu est facultatif (sometimes), mais s'il est présent, il doit être une chaîne non vide
            'content' => 'sometimes|required|string',

            // Le champ "is_start" est facultatif et doit être de type booléen s'il est présent
            'is_start' => 'boolean',
        ];
    }
}

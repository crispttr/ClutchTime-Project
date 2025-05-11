<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChoiceRequest extends FormRequest
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
            // L'identifiant du chapitre est requis et doit exister dans la table "chapters"
            'chapter_id' => 'required|exists:chapters,id',

            // Le texte du choix est obligatoire, doit être une chaîne de caractères et avoir au maximum 255 caractères
            'text' => 'required|string|max:255',

            // L'identifiant du chapitre suivant est facultatif mais, s'il est présent, il doit exister dans la table "chapters"
            'next_chapter_id' => 'nullable|exists:chapters,id',
        ];
    }
}

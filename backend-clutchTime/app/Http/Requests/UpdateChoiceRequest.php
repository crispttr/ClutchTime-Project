<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChoiceRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Par défaut, l'autorisation est définie sur "false"
        // Pour permettre cette action, remplacer par "true"
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
            // L'identifiant du chapitre est facultatif (sometimes) mais doit exister dans la table "chapters" s'il est présent
            'chapter_id' => 'sometimes|exists:chapters,id',

            // Le texte du choix est facultatif (sometimes), mais s'il est présent, il doit être une chaîne non vide avec un maximum de 255 caractères
            'text' => 'sometimes|required|string|max:255',

            // L'identifiant du chapitre suivant est facultatif (nullable), mais s'il est présent, il doit exister dans la table "chapters"
            'next_chapter_id' => 'nullable|exists:chapters,id',
        ];
    }
}

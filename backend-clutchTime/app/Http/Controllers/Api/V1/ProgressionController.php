<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Progression;

class ProgressionController extends Controller
{
    // Enregistrer ou mettre à jour la progression d'un utilisateur
    public function store(Request $request)
    {
        // Récupérer l'utilisateur actuellement connecté
        $user = $request->user();
        
        // Vérifier si l'utilisateur est bien authentifié
        if (!$user) {
            return response()->json(['message' => 'Non authentifié'], 401); // Retourne une erreur 401 si non connecté
        }

        // Validation des champs requis pour enregistrer la progression
        $request->validate([
            'story_id' => 'required|exists:stories,id',   // Vérifie que l'histoire existe
            'chapter_id' => 'required|exists:chapters,id', // Vérifie que le chapitre existe
        ]);

        // Enregistrer ou mettre à jour la progression dans la base de données
        $progression = Progression::updateOrCreate(
            [
                'user_id' => $user->id,           // Associer la progression à l'utilisateur connecté
                'story_id' => $request->story_id  // Associer à l'histoire en cours
            ],
            [
                'chapter_id' => $request->chapter_id // Mettre à jour le chapitre actuel
            ]
        );
        
        // Retourner la progression mise à jour avec un statut 200 (OK)
        return response()->json($progression, 200);
    }

    // Récupérer la progression actuelle pour une histoire donnée
    public function show(Request $request, $story_id)
    {
        // Récupérer l'utilisateur actuellement connecté
        $user = $request->user();

        // Vérifier si l'utilisateur est bien authentifié
        if (!$user) {
            return response()->json(['message' => 'Non authentifié'], 401); // Retourne une erreur 401 si non connecté
        }

        // Récupérer la progression pour l'histoire spécifiée
        $progression = Progression::where('user_id', $user->id)
            ->where('story_id', $story_id)
            ->first();

        // Vérifier si une progression existe pour cette histoire
        if (!$progression) {
            return response()->json(['message' => 'Pas de progression'], 200);
        }

        // Retourner la progression avec un statut 200 (OK) et un header JSON
        return response()->json($progression, 200, ['Content-Type' => 'application/json']);
    }

    // Supprimer la progression pour une histoire donnée
    public function destroy(Request $request, $story_id)
    {
        // Récupérer l'utilisateur actuellement connecté
        $user = $request->user();

        // Vérifier si l'utilisateur est bien authentifié
        if (!$user) {
            return response()->json(['message' => 'Non authentifié'], 401); // Retourne une erreur 401 si non connecté
        }

        // Chercher la progression de l'utilisateur pour l'histoire spécifiée
        $progression = Progression::where('user_id', $user->id)
            ->where('story_id', $story_id)
            ->first();

        // Vérifier si la progression existe
        if (!$progression) {
            return response()->json(['message' => 'Aucune progression à supprimer'], 404); // Retourne une erreur 404 si inexistante
        }

        // Supprimer la progression
        $progression->delete();

        // Retourner un message de confirmation avec un statut 200 (OK)
        return response()->json(['message' => 'Progression supprimée'], 200);
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;

class ChapterController extends Controller
{
    // Affiche la liste de tous les chapitres avec les histoires et les choix associés
    public function index()
    {
        // Récupérer tous les chapitres avec leurs histoires et choix liés
        return response()->json(
            Chapter::with(['story', 'choices'])->get(),
            200 // Renvoie un statut 200 pour indiquer que la requête est réussie
        );
    }

    // Enregistre un nouveau chapitre dans la base de données
    public function store(StoreChapterRequest $request)
    {
        // Créer un chapitre en utilisant les données validées de la requête
        $chapter = Chapter::create($request->validated());

        // Renvoie le chapitre créé avec un statut 201 (Créé)
        return response()->json($chapter, 201);
    }

    // Affiche les détails d'un chapitre spécifique
    public function show(Chapter $chapter)
    {
        // Charger les relations 'story' et 'choices' pour le chapitre
        $chapter->load(['story', 'choices']);

        // Renvoie le chapitre avec un statut 200 (OK)
        return response()->json($chapter, 200);
    }

    // Met à jour un chapitre existant
    public function update(UpdateChapterRequest $request, Chapter $chapter)
    {
        // Mettre à jour le chapitre avec les nouvelles données validées
        $chapter->update($request->validated());

        // Renvoie le chapitre mis à jour avec un statut 200
        return response()->json($chapter, 200);
    }

    // Supprime un chapitre de la base de données
    public function destroy(Chapter $chapter)
    {
        // Supprimer le chapitre
        $chapter->delete();

        // Renvoie un message de confirmation avec un statut 200
        return response()->json(['message' => 'Chapitre supprimé'], 200);
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStoryRequest;
use App\Http\Requests\UpdateStoryRequest;

class StoryController extends Controller
{
    // Récupère la liste de toutes les histoires
    public function index()
    {
        // Renvoyer toutes les histoires depuis la base de données avec un statut 200 (OK)
        return response()->json(Story::all(), 200);
    }

    // Enregistre une nouvelle histoire dans la base de données
    public function store(StoreStoryRequest $request)
    {
        // Créer une nouvelle histoire en utilisant les données validées
        $story = Story::create($request->validated());

        // Retourner l'histoire créée avec un statut 201 (Créé)
        return response()->json($story, 201);
    }

    // Affiche les détails d'une histoire spécifique
    public function show(Story $story)
    {
        // Renvoyer l'histoire demandée avec un statut 200 (OK)
        return response()->json($story, 200);
    }

    // Met à jour une histoire existante
    public function update(UpdateStoryRequest $request, Story $story)
    {
        // Mettre à jour l'histoire avec les données validées
        $story->update($request->validated());

        // Retourner l'histoire mise à jour avec un statut 200 (OK)
        return response()->json($story, 200);
    }

    // Supprime une histoire de la base de données
    public function destroy(Story $story)
    {
        // Supprimer l'histoire
        $story->delete();

        // Retourner un message de confirmation avec un statut 200 (OK)
        return response()->json(['message' => 'Histoire supprimée'], 200);
    }
}

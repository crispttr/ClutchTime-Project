<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use App\Http\Requests\StoreChoiceRequest;
use App\Http\Requests\UpdateChoiceRequest;

class ChoiceController extends Controller
{
    // Affiche la liste de tous les choix avec les chapitres associés
    public function index()
    {
        // Récupérer tous les choix avec leurs chapitres d'origine et chapitres suivants
        return response()->json(
            Choice::with(['chapter', 'nextChapter'])->get(),
            200 // Renvoie un statut 200 pour indiquer le succès
        );
    }

    // Enregistre un nouveau choix dans la base de données
    public function store(StoreChoiceRequest $request)
    {
        // Créer un choix en utilisant les données validées de la requête
        $choice = Choice::create($request->validated());

        // Renvoie le choix créé avec un statut 201 (Créé)
        return response()->json($choice, 201);
    }

    // Affiche les détails d'un choix spécifique
    public function show(Choice $choice)
    {
        // Charger les relations 'chapter' et 'nextChapter' pour le choix
        $choice->load(['chapter', 'nextChapter']);

        // Renvoie le choix avec un statut 200 (OK)
        return response()->json($choice, 200);
    }

    // Met à jour un choix existant
    public function update(UpdateChoiceRequest $request, Choice $choice)
    {
        // Mettre à jour le choix avec les nouvelles données validées
        $choice->update($request->validated());

        // Renvoie le choix mis à jour avec un statut 200
        return response()->json($choice, 200);
    }

    // Supprime un choix de la base de données
    public function destroy(Choice $choice)
    {
        // Supprimer le choix
        $choice->delete();

        // Renvoie un message de confirmation avec un statut 200
        return response()->json(['message' => 'Choix supprimé'], 200);
    }
}

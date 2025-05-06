<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Importation des contrôleurs nécessaires
use App\Http\Controllers\Api\V1\StoryController;
use App\Http\Controllers\Api\V1\ChapterController;
use App\Http\Controllers\Api\V1\ChoiceController;
use App\Http\Controllers\Api\V1\ProgressionController;
use App\Http\Controllers\Api\WelcomeMessageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Groupe de routes versionnées pour l'API
Route::prefix('v1')->group(function () {
    // Routes RESTful pour les histoires, chapitres et choix
    Route::apiResource('stories', StoryController::class);
    Route::apiResource('chapters', ChapterController::class);
    Route::apiResource('choices', ChoiceController::class);
});

// Inclut les routes d'authentification Laravel Breeze ou Fortify
require __DIR__.'/auth.php';

// Route protégée : permet de récupérer les infos de l'utilisateur connecté
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes protégées (requièrent que l'utilisateur soit connecté)
Route::middleware('auth:sanctum')->group(function () {
    // Récupère la progression de l'utilisateur pour une histoire donnée
    Route::get('/v1/progressions/{story_id}', [ProgressionController::class, 'show']);

    // Enregistre ou met à jour la progression
    Route::post('/v1/progressions', [ProgressionController::class, 'store']);

    // Message de bienvenue protégé
    Route::get('/welcome-message', WelcomeMessageController::class);

    // Déconnexion de l'utilisateur
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    // Supprime la progression d'une histoire pour l'utilisateur connecté
    Route::delete('/v1/progressions/{story_id}', [ProgressionController::class, 'destroy']);
});

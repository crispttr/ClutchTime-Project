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
        $user = $request->user();
    
        if (!$user) {
            return response()->json(['message' => 'Non authentifié'], 401);
        }
    
        $request->validate([
            'story_id' => 'required|exists:stories,id',
            'chapter_id' => 'required|exists:chapters,id',
        ]);
    
        $progression = Progression::updateOrCreate(
            [
                'user_id' => $user->id,
                'story_id' => $request->story_id
            ],
            [
                'chapter_id' => $request->chapter_id
            ]
        );
       
        return response()->json($progression, 200);
    }
    

    // Récupérer la progression actuelle pour une histoire donnée
    public function show(Request $request, $story_id)
{
    $user = $request->user();

    if (!$user) {
        return response()->json(['message' => 'Non authentifié'], 401);
    }

    $progression = Progression::where('user_id', $user->id)
        ->where('story_id', $story_id)
        ->first();

    if (!$progression) {
        return response()->json(['message' => 'Pas de progression'], 200);
    }

    return response()->json($progression, 200, ['Content-Type' => 'application/json']);
}

    
}

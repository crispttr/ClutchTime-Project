<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Pour utiliser les usines de création de données
use Illuminate\Database\Eloquent\Model;

class Progression extends Model
{
    use HasFactory;

    // Les champs qu'on peut remplir directement
    protected $fillable = ['user_id', 'story_id', 'chapter_id'];

    // Relation : La progression appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation : La progression est liée à une histoire
    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    // Relation : La progression est liée à un chapitre
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}

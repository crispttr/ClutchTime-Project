<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    // Liste des champs qu'on peut remplir directement
    protected $fillable = ['story_id', 'title', 'content', 'is_start'];

    // Relation : Un chapitre appartient à une histoire
    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    // Relation : Un chapitre peut avoir plusieurs choix
    public function choices()
    {
        return $this->hasMany(Choice::class);
    }

    // Récupère uniquement les choix qui mènent à un autre chapitre
    public function availableChoices()
    {
        return $this->choices()->whereNotNull('next_chapter_id');
    }
}

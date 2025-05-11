<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    // Les champs qu'on peut remplir directement
    protected $fillable = ['title', 'description'];

    // Relation : Une histoire peut avoir plusieurs chapitres
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    // Relation : Une histoire peut avoir plusieurs progressions (par utilisateur)
    public function progressions()
    {
        return $this->hasMany(UserProgress::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Les champs qu'on peut remplir directement lors de la création ou la mise à jour d'un utilisateur
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Les attributs à masquer lors de la conversion de l'objet en JSON
    protected $hidden = [
        'password',       // On ne veut pas que le mot de passe apparaisse dans les réponses
        'remember_token', // Le token de session est aussi masqué
    ];

    // Les attributs qui doivent être typés ou modifiés avant d'être enregistrés en base
    protected function casts(): array
    {
        return [
            // La date de vérification de l'email est formatée en datetime
            'email_verified_at' => 'datetime',

            // Le mot de passe est automatiquement haché
            'password' => 'hashed',
        ];
    }

    // Mutator : Formate le nom pour que la première lettre soit toujours en majuscule
    public function setNameAttribute($value)
    {
        // On met tout en minuscule puis on capitalise la première lettre
        $this->attributes['name'] = ucfirst(strtolower($value));
    }
}

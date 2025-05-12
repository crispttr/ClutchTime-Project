<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Choice;

class ChoiceSeeder extends Seeder
{
    public function run(): void
    {
        Choice::insert([
            // Choix du chapitre 1
            ['chapter_id' => 1, 'text' => 'Accepter de débuter sur le banc', 'next_chapter_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 1, 'text' => 'Insister pour jouer titulaire', 'next_chapter_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 2
            ['chapter_id' => 2, 'text' => 'Jouer prudemment pour assurer', 'next_chapter_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 2, 'text' => 'Jouer avec audace pour impressionner', 'next_chapter_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 3
            ['chapter_id' => 3, 'text' => 'Tenter un tir risqué', 'next_chapter_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 3, 'text' => 'Passer à l\'ailier', 'next_chapter_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 4
            ['chapter_id' => 4, 'text' => 'Te rattraper en défense', 'next_chapter_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 4, 'text' => 'Demander à sortir pour te calmer', 'next_chapter_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 5
            ['chapter_id' => 5, 'text' => 'Continuer à distribuer le jeu', 'next_chapter_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 5, 'text' => 'Chercher à marquer toi-même', 'next_chapter_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 6
            ['chapter_id' => 6, 'text' => 'Tenter un contre agressif', 'next_chapter_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 6, 'text' => 'Rester discipliné défensivement', 'next_chapter_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 7
            ['chapter_id' => 7, 'text' => 'Mettre la pression sur le meneur', 'next_chapter_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 7, 'text' => 'Maintenir le rythme collectif', 'next_chapter_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 8
            ['chapter_id' => 8, 'text' => 'Tenter le dunk spectaculaire', 'next_chapter_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 8, 'text' => 'Opter pour un lay-up sûr', 'next_chapter_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 9
            ['chapter_id' => 9, 'text' => 'Tenter un dunk spectaculaire', 'next_chapter_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 9, 'text' => 'Assurer le panier', 'next_chapter_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 10
            ['chapter_id' => 10, 'text' => 'Rester concentré malgré l\'euphorie', 'next_chapter_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 10, 'text' => 'Continuer à jouer spectaculaire', 'next_chapter_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 11
            ['chapter_id' => 11, 'text' => 'Travailler plus dur à l\'entraînement', 'next_chapter_id' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 11, 'text' => 'Contester la décision du coach', 'next_chapter_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 12
            ['chapter_id' => 12, 'text' => 'Parler au recruteur NBA', 'next_chapter_id' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 12, 'text' => 'Parler à l\'agent européen', 'next_chapter_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 13
            ['chapter_id' => 13, 'text' => 'Accepter l\'essai NBA', 'next_chapter_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 13, 'text' => 'Demander plus de garanties', 'next_chapter_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 14
            ['chapter_id' => 14, 'text' => 'Signer en Euroligue', 'next_chapter_id' => 17, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 14, 'text' => 'Tenter ta chance en NBA', 'next_chapter_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 15
            ['chapter_id' => 15, 'text' => 'S\'entraîner intensivement', 'next_chapter_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 15, 'text' => 'Travailler avec un coach mental', 'next_chapter_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 16
            ['chapter_id' => 16, 'text' => 'Privilégier le collectif', 'next_chapter_id' => 19, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 16, 'text' => 'Chercher à te démarquer', 'next_chapter_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 17
            ['chapter_id' => 17, 'text' => 'Adapter ton jeu au style européen', 'next_chapter_id' => 20, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 17, 'text' => 'Imposer ton style américain', 'next_chapter_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 18
            ['chapter_id' => 18, 'text' => 'Suivre scrupuleusement la rééducation', 'next_chapter_id' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['chapter_id' => 18, 'text' => 'Accélérer le retour malgré les risques', 'next_chapter_id' => 23, 'created_at' => now(), 'updated_at' => now()], // Modification: mène à la fin "Reconversion"
            
            // Choix du chapitre 19
            ['chapter_id' => 19, 'text' => 'Saisir l\'opportunité NBA', 'next_chapter_id' => 22, 'created_at' => now(), 'updated_at' => now()], // Modification: mène à la fin "Star NBA"
            ['chapter_id' => 19, 'text' => 'Rester en G-League pour progresser', 'next_chapter_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            
            // Choix du chapitre 20
            ['chapter_id' => 20, 'text' => 'Rester fidèle à ton club européen', 'next_chapter_id' => 21, 'created_at' => now(), 'updated_at' => now()], // Modification: mène à la fin "Légende de l'Euroligue"
            ['chapter_id' => 20, 'text' => 'Tenter ta chance en NBA', 'next_chapter_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            
            // Nouveaux choix pour s'assurer que toutes les fins sont accessibles
            ['chapter_id' => 16, 'text' => 'Persévérer malgré les difficultés', 'next_chapter_id' => 22, 'created_at' => now(), 'updated_at' => now()], // Nouvelle option vers "Star NBA"
            ['chapter_id' => 17, 'text' => 'S\'engager totalement dans ta carrière européenne', 'next_chapter_id' => 21, 'created_at' => now(), 'updated_at' => now()], // Nouvelle option vers "Légende de l'Euroligue"
            ['chapter_id' => 15, 'text' => 'Réévaluer tes objectifs de carrière', 'next_chapter_id' => 23, 'created_at' => now(), 'updated_at' => now()], // Nouvelle option vers "Reconversion"
        ]);
    }
}
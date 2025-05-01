<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Story::create([
            'title' => 'La montée vers la gloire',
            'description' => 'Tu es un jeune joueur en pleine ascension. Ton destin dépend de tes choix.',
        ]);
    }
    
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Story;

class StorySeeder extends Seeder
{
    public function run(): void
    {
        Story::create([
            'title' => "Clutch Time – L'ascension de Malik",
            'description' => "Tu es Malik, jeune espoir du basket. Chaque choix façonne ta carrière entre gloire, blessures et rivalités."
        ]);
    }
}

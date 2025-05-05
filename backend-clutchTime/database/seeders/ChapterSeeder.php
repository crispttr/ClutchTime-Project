<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chapter;

class ChapterSeeder extends Seeder
{
    public function run(): void
    {
        Chapter::insert([
            [
                'id' => 1,
                'story_id' => 1,
                'title' => 'Premier match pro',
                'content' => 'C’est ton premier match. Coach hésite à te titulariser.',
                'is_start' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'story_id' => 1,
                'title' => 'Tu débutes sur le banc',
                'content' => 'Tu observes, analyses, puis entres à la mi-temps.',
                'is_start' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'story_id' => 1,
                'title' => 'Tu es titularisé',
                'content' => 'La pression monte, tu as le ballon dès le début.',
                'is_start' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'story_id' => 1,
                'title' => 'Tu forces un tir',
                'content' => 'Le tir est raté... Le coach te sort du match.',
                'is_start' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'story_id' => 1,
                'title' => 'Tu passes à ton ailier',
                'content' => 'Passe décisive. Tu gagnes la confiance de l’équipe.',
                'is_start' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Choice;

class ChoiceSeeder extends Seeder
{
    public function run(): void
    {
        Choice::insert([
            [
                'chapter_id' => 1,
                'text' => 'Accepter de débuter sur le banc',
                'next_chapter_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chapter_id' => 1,
                'text' => 'Insister pour jouer titulaire',
                'next_chapter_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chapter_id' => 3,
                'text' => 'Tenter un tir risqué',
                'next_chapter_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chapter_id' => 3,
                'text' => 'Faire une passe à ton ailier',
                'next_chapter_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

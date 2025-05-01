<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chapters = \App\Models\Chapter::all();
    
        \App\Models\Choice::insert([
            [
                'chapter_id' => $chapters[0]->id,
                'text' => 'Tenter un tir risqué',
                'next_chapter_id' => $chapters[1]->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chapter_id' => $chapters[0]->id,
                'text' => 'Passer la balle',
                'next_chapter_id' => null, // fin ouverte
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
    
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $story = \App\Models\Story::first();
    
        \App\Models\Chapter::insert([
            [
                'story_id' => $story->id,
                'title' => 'Le premier match',
                'content' => 'Tu entres sur le terrain pour ton premier match officiel...',
                'is_start' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'story_id' => $story->id,
                'title' => 'Le coach doute de toi',
                'content' => 'Tu n’as pas été très convaincant. Le coach hésite à te titulariser...',
                'is_start' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
    
}

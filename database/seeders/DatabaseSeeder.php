<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Question::factory()
            ->has(Answer::factory()->isCorrect()->count(1))
            ->has(Answer::factory()->count(3))
            ->count(50)
            ->create();
    }
}

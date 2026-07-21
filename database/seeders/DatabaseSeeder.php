<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        /**
         * Seed the application's database.
         */
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Project::factory()
            ->count(22)
            ->for($user)
            ->has(Task::factory()->count(11))
            ->create();

        User::factory()
            ->count(3)
            ->has(
                Project::factory()
                    ->count(2)
                    ->has(Task::factory()->count(3))
            )
            ->create();
    }
}
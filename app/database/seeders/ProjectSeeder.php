<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@worknest.test',
            'password' => bcrypt('password'),
        ]);

        // Create sample projects
        $projects = [
            [
                'name' => 'Website Redesign',
                'description' => 'Complete overhaul of company website with modern design',
                'status' => 'in_progress',
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(20),
            ],
            [
                'name' => 'Mobile App Development',
                'description' => 'iOS and Android app development for customer portal',
                'status' => 'planning',
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(60),
            ],
            [
                'name' => 'Database Migration',
                'description' => 'Migrate legacy database to new cloud infrastructure',
                'status' => 'completed',
                'start_date' => now()->subDays(30),
                'end_date' => now()->subDays(5),
            ],
        ];

        foreach ($projects as $projectData) {
            $project = Project::create([
                ...$projectData,
                'user_id' => $user->id,
            ]);

            // Create sample tasks for each project
            $tasks = [
                [
                    'title' => 'Design mockups',
                    'description' => 'Create initial design mockups for review',
                    'status' => 'completed',
                    'priority' => 'high',
                    'due_date' => now()->addDays(7),
                ],
                [
                    'title' => 'Frontend development',
                    'description' => 'Implement frontend components',
                    'status' => 'in_progress',
                    'priority' => 'medium',
                    'due_date' => now()->addDays(14),
                ],
                [
                    'title' => 'Backend API',
                    'description' => 'Develop REST API endpoints',
                    'status' => 'todo',
                    'priority' => 'high',
                    'due_date' => now()->addDays(21),
                ],
            ];

            foreach ($tasks as $taskData) {
                Task::create([
                    ...$taskData,
                    'project_id' => $project->id,
                    'assigned_to' => $user->id,
                ]);
            }
        }
    }
}

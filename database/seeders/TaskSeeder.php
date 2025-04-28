<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        if ($user) {
            // Create a todo task
            $todoTask = Task::create([
                'user_id' => $user->id,
                'title' => 'Complete Project Documentation',
                'description' => 'Write comprehensive documentation for the project',
                'status' => 'todo',
                'due_date' => now()->addDays(3),
            ]);

            $todoTask->subtasks()->createMany([
                ['title' => 'Create API documentation', 'is_completed' => false],
                ['title' => 'Write user guide', 'is_completed' => false],
            ]);

            // Create an in-progress task
            $inProgressTask = Task::create([
                'user_id' => $user->id,
                'title' => 'Implement New Features',
                'description' => 'Add new features to the application',
                'status' => 'in_progress',
                'due_date' => now()->addDays(5),
            ]);

            $inProgressTask->subtasks()->createMany([
                ['title' => 'Design UI components', 'is_completed' => true],
                ['title' => 'Implement backend logic', 'is_completed' => false],
            ]);

            // Create a done task
            $doneTask = Task::create([
                'user_id' => $user->id,
                'title' => 'Fix Bugs',
                'description' => 'Resolve reported issues',
                'status' => 'done',
                'due_date' => now()->subDays(2),
            ]);

            $doneTask->subtasks()->createMany([
                ['title' => 'Fix login issue', 'is_completed' => true],
                ['title' => 'Resolve database error', 'is_completed' => true],
            ]);
        }
    }
}

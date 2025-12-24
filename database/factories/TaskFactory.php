<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Project::factory(),
            'content' => fake()->randomElement([
                'Gather initial requirements',
                'Design database schema',
                'Setup development environment',
                'Create API endpoints',
                'Implement frontend authentication',
                'Design UI mockups',
                'Write automated tests',
                'Deploy to staging server',
                'Fix reported bugs',
                'Conduct user acceptance testing',
            ]),
            'is_completed' => fake()->boolean(40), // 40% chance of being completed
        ];
    }
}

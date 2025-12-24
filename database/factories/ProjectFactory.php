<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => \App\Models\Client::factory(),
            'name' => fake()->randomElement([
                'Website Redesign', 
                'Mobile App Development', 
                'SEO Optimization Campaign', 
                'E-commerce Platform Migration', 
                'Internal Dashboard Tool', 
                'Marketing Landing Pages',
                'Cloud Infrastructure Setup',
                'Legacy System Refactor'
            ]) . ' - ' . fake()->word(),
            'description' => fake()->paragraphs(2, true),
            'status' => fake()->randomElement(['pending', 'in_progress', 'completed', 'on_hold']),
            'deadline' => fake()->dateTimeBetween('now', '+6 months'),
        ];
    }
}

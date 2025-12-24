<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password', // Password will be hashed by the User model's 'hashed' cast
        ]);

        \App\Models\Client::factory(10)->create()->each(function ($client) {
            \App\Models\Project::factory(rand(2, 5))->create([
                'client_id' => $client->id,
            ])->each(function ($project) {
                \App\Models\Task::factory(rand(3, 8))->create([
                    'project_id' => $project->id,
                ]);
            });
        });
        // Seed Invoices
        $this->call(InvoiceSeeder::class);
        $this->call(QuotationSeeder::class);
    }
}

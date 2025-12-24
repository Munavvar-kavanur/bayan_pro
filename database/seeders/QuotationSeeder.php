<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Project;
use Illuminate\Database\Seeder;

class QuotationSeeder extends Seeder
{
    public function run()
    {
        $clients = Client::with('projects')->get();

        if ($clients->isEmpty()) {
            $this->command->info('No clients found. Please seed clients first.');
            return;
        }

        foreach ($clients as $client) {
            // Create 1-3 quotations per client
            $numQuotations = rand(1, 3);

            for ($i = 0; $i < $numQuotations; $i++) {
                $status = fake()->randomElement(['draft', 'sent', 'accepted', 'rejected']);
                $issueDate = fake()->dateTimeBetween('-2 months', 'now');
                $expiryDate = fake()->dateTimeBetween($issueDate, '+14 days');
                
                // 70% chance to link a project if available
                $projectId = null;
                if ($client->projects->isNotEmpty() && rand(1, 100) <= 70) {
                    $projectId = $client->projects->random()->id;
                }

                $quotation = Quotation::create([
                    'client_id' => $client->id,
                    'project_id' => $projectId,
                    'issue_date' => $issueDate,
                    'expiry_date' => $expiryDate,
                    'status' => $status,
                    'notes' => fake()->sentence(),
                    'tax_rate' => 5.00,
                    'discount_type' => 'fixed',
                    'discount_value' => 0,
                    'total_amount' => 0, // Will update after items
                ]);

                // Add 2-5 items
                $total = 0;
                $numItems = rand(2, 5);

                for ($j = 0; $j < $numItems; $j++) {
                    $qty = rand(1, 10);
                    $price = rand(50, 500);
                    $amount = $qty * $price;

                    QuotationItem::create([
                        'quotation_id' => $quotation->id,
                        'title' => fake()->words(3, true),
                        'description' => fake()->sentence(),
                        'quantity' => $qty,
                        'unit_price' => $price,
                        'amount' => $amount,
                    ]);

                    $total += $amount;
                }

                $tax = $total * 0.05;
                $finalTotal = $total + $tax;
                
                $quotation->update(['total_amount' => $finalTotal]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Project;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run()
    {
        $clients = Client::with('projects')->get();

        if ($clients->isEmpty()) {
            $this->command->info('No clients found. Please seed clients first.');
            return;
        }

        foreach ($clients as $client) {
            // Create 1-3 invoices per client
            $numInvoices = rand(1, 3);

            for ($i = 0; $i < $numInvoices; $i++) {
                $status = fake()->randomElement(['draft', 'sent', 'paid', 'overdue']);
                $issueDate = fake()->dateTimeBetween('-3 months', 'now');
                $dueDate = fake()->dateTimeBetween($issueDate, '+1 month');
                
                // 70% chance to link a project if available
                $projectId = null;
                if ($client->projects->isNotEmpty() && rand(1, 100) <= 70) {
                    $projectId = $client->projects->random()->id;
                }

                $invoice = Invoice::create([
                    'client_id' => $client->id,
                    'project_id' => $projectId,
                    'issue_date' => $issueDate,
                    'due_date' => $dueDate,
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

                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'title' => fake()->words(3, true),
                        'description' => fake()->sentence(),
                        'quantity' => $qty,
                        'unit_price' => $price,
                        'amount' => $amount,
                    ]);

                    $total += $amount;
                }

                // Update invoice total (simple calc, form logic might be more complex with tax/discount but this is demo data)
                // The InvoiceForm logic: subtotal / (1 + tax) ... wait, usually DB stores final calculations.
                // I'll just store the simple total of items + tax for now to have "some" value.
                $tax = $total * 0.05;
                $finalTotal = $total + $tax;
                
                $invoice->update(['total_amount' => $finalTotal]);
            }
        }
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use App\Models\Project;
use App\Models\Invoice;
use App\Models\Quotation;

class GlobalSearch extends Component
{
    public $search = '';
    public $results = [];

    public function updatedSearch()
    {
        $this->results = [];

        if (strlen($this->search) < 2) {
            return;
        }

        $term = '%' . $this->search . '%';

        // Search Clients
        $clients = Client::where('name', 'like', $term)
            ->orWhere('company_name', 'like', $term)
            ->limit(3)
            ->get();

        foreach ($clients as $client) {
            $this->results[] = [
                'type' => 'Client',
                'title' => $client->company_name ?? $client->name,
                'subtitle' => $client->email,
                'url' => route('clients.show', $client),
            ];
        }

        // Search Projects
        $projects = Project::where('name', 'like', $term)
            ->limit(3)
            ->get();

        foreach ($projects as $project) {
            $this->results[] = [
                'type' => 'Project',
                'title' => $project->name,
                'subtitle' => $project->client->name ?? 'Unknown Client',
                'url' => route('projects.show', $project),
            ];
        }

        // Search Invoices
        $invoices = Invoice::where('id', 'like', $this->search) // Exact ID match or partial
            ->orWhereHas('client', function ($query) use ($term) {
                $query->where('name', 'like', $term)
                      ->orWhere('company_name', 'like', $term);
            })
            ->limit(3)
            ->get();
        
        // Also check if search is numeric for exact ID match on Invoice
         if (is_numeric($this->search)) {
             $invoiceById = Invoice::find($this->search);
             if ($invoiceById && !$invoices->contains($invoiceById)) {
                 $invoices->push($invoiceById);
             }
         }


        foreach ($invoices as $invoice) {
            $this->results[] = [
                'type' => 'Invoice',
                'title' => 'Invoice #' . str_pad($invoice->id, 5, '0', STR_PAD_LEFT),
                'subtitle' => $invoice->client->company_name ?? $invoice->client->name,
                'url' => route('invoices.show', $invoice),
            ];
        }

        // Search Quotations
        $quotations = Quotation::where('id', 'like', $this->search)
             ->orWhereHas('client', function ($query) use ($term) {
                $query->where('name', 'like', $term)
                      ->orWhere('company_name', 'like', $term);
            })
            ->limit(3)
            ->get();
            
        if (is_numeric($this->search)) {
             $quotationById = Quotation::find($this->search);
             if ($quotationById && !$quotations->contains($quotationById)) {
                 $quotations->push($quotationById);
             }
         }

        foreach ($quotations as $quotation) {
            $this->results[] = [
                'type' => 'Quotation',
                'title' => 'Quotation #' . $quotation->id,
                'subtitle' => $quotation->client->company_name ?? $quotation->client->name,
                'url' => route('quotations.show', $quotation),
            ];
        }
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}

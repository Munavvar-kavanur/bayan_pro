<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use App\Models\Invoice;

class InvoiceForm extends Component
{
    public $invoice;
    public $client_id;
    public $client_search = ''; // Search input
    public $project_id;
    public $project_search = ''; // Search input
    public $issue_date;
    public $due_date;
    public $status = 'draft';
    public $notes;
    public $items = [];
    // client_projects removed as unused 

    public $tax_rate = 0;
    public $discount_type = 'fixed';
    public $discount_value = 0;

    protected $rules = [
        'client_id' => 'required|exists:clients,id',
        'project_id' => 'nullable|exists:projects,id',
        'issue_date' => 'required|date',
        'due_date' => 'required|date|after_or_equal:issue_date',
        'status' => 'required|in:draft,sent,paid,overdue',
        'tax_rate' => 'required|numeric|min:0',
        'discount_type' => 'required|in:fixed,percent',
        'discount_value' => 'required|numeric|min:0',
        'items' => 'required|array|min:1',
        'items.*.title' => 'required|string',
        'items.*.description' => 'nullable|string',
        'items.*.quantity' => 'required|numeric|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
    ];

    public function mount($invoice = null)
    {
        if ($invoice) {
            $this->invoice = $invoice;
            $this->client_id = $invoice->client_id;
            $this->client_search = $invoice->client->company_name ?? $invoice->client->name;

            $this->project_id = $invoice->project_id;
            if ($invoice->project) {
                $this->project_search = $invoice->project->name;
            }

            $this->issue_date = $invoice->issue_date->format('Y-m-d');
            $this->due_date = $invoice->due_date->format('Y-m-d');
            $this->status = $invoice->status;
            $this->notes = $invoice->notes;
            $this->tax_rate = $invoice->tax_rate;
            $this->discount_type = $invoice->discount_type;
            $this->discount_value = $invoice->discount_value;

            $this->loadProjects();

            foreach ($invoice->items as $item) {
                $this->items[] = [
                    'title' => $item->title,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                ];
            }
        } else {
            $this->issue_date = now()->format('Y-m-d');
            $this->due_date = now()->addDays(30)->format('Y-m-d');
            $this->items[] = [
                'title' => '',
                'description' => '',
                'quantity' => 1,
                'unit_price' => 0,
            ];
        }
    }

    public function addItem()
    {
        $this->items[] = [
            'title' => '',
            'description' => '',
            'quantity' => 1,
            'unit_price' => 0,
        ];
    }

    public function updatedClientSearch()
    {
        // Reset ID when search changes to ensure data consistency
        $this->client_id = null;
        $this->project_id = null;
        $this->project_search = '';
    }

    public function updatedProjectSearch()
    {
        $this->project_id = null;
    }

    public function selectClient($id)
    {
        \Illuminate\Support\Facades\Log::info("SelectClient Called with ID: " . $id);
        $this->client_id = $id;
        $client = Client::find($id);
        if ($client) {
            $this->client_search = $client->company_name ?? $client->name;
            \Illuminate\Support\Facades\Log::info("Client Found: " . $this->client_search);
        } else {
            \Illuminate\Support\Facades\Log::error("Client NOT Found: " . $id);
        }

        // Reset project when client changes
        $this->project_id = null;
        $this->project_search = '';
    }

    public function clearClient()
    {
        $this->client_id = null;
        $this->client_search = '';
        $this->project_id = null;
        $this->project_search = '';
    }

    public function selectProject($id)
    {
        $this->project_id = $id;
        $project = \App\Models\Project::find($id);
        $this->project_search = $project->name;
    }

    public function clearProject()
    {
        $this->project_id = null;
        $this->project_search = '';
    }

    // updatedClientId and loadProjects are removed as they are redundant with render() logic

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function calculateTotal()
    {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += (floatval($item['quantity']) * floatval($item['unit_price']));
        }

        $discountAmount = 0;
        if ($this->discount_type === 'fixed') {
            $discountAmount = floatval($this->discount_value);
        } else {
            $discountAmount = $subtotal * (floatval($this->discount_value) / 100);
        }

        $taxable = max(0, $subtotal - $discountAmount);
        $taxAmount = $taxable * (floatval($this->tax_rate) / 100);

        return $taxable + $taxAmount;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'client_id' => $this->client_id,
            'project_id' => $this->project_id ?: null,
            'issue_date' => $this->issue_date,
            'due_date' => $this->due_date,
            'status' => $this->status,
            'notes' => $this->notes,
            'tax_rate' => $this->tax_rate,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'total_amount' => $this->calculateTotal(),
        ];

        if ($this->invoice) {
            $this->invoice->update($data);
            $this->invoice->items()->delete();
        } else {
            $this->invoice = Invoice::create($data);
        }

        foreach ($this->items as $item) {
            $this->invoice->items()->create([
                'title' => $item['title'],
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'amount' => floatval($item['quantity']) * floatval($item['unit_price']),
            ]);
        }

        return redirect()->route('invoices.show', $this->invoice)->with('success', 'Invoice saved successfully.');
    }

    public function render()
    {
        // 1. Client Search Logic
        $clientsQuery = Client::query();

        if (!empty($this->client_search)) {
            $term = $this->client_search;
            $clientsQuery->where(function ($q) use ($term) {
                $q->where('name', 'like', '%' . $term . '%')
                    ->orWhere('company_name', 'like', '%' . $term . '%');
            })->orderBy('name');
        } else {
            // Default: Show latest or alphabetical
            $clientsQuery->orderBy('name');
        }

        $clients = $clientsQuery->take(50)->get();

        // 2. Project Search Logic
        $projects = [];
        if ($this->client_id) {
            $projectsQuery = \App\Models\Project::where('client_id', $this->client_id);

            if (!empty($this->project_search)) {
                $term = $this->project_search;
                $projectsQuery->where('name', 'like', '%' . $term . '%')
                    ->orderBy('name');
            } else {
                $projectsQuery->orderBy('name');
            }

            $projects = $projectsQuery->take(50)->get();
        }

        return view('livewire.invoice-form', [
            'found_clients' => $clients,
            'found_projects' => $projects,
            'total' => $this->calculateTotal(),
        ]);
    }
}

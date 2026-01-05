<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use App\Models\Quotation;

class QuotationForm extends Component
{
    public $quotation;
    public $client_id;
    public $client_search = '';
    public $project_id;
    public $project_search = '';
    public $issue_date;
    public $expiry_date;
    public $status = 'draft';
    public $notes;
    public $items = [];

    public $tax_rate = 0;
    public $discount_type = 'fixed';
    public $discount_value = 0;

    protected $rules = [
        'client_id' => 'required|exists:clients,id',
        'project_id' => 'nullable|exists:projects,id',
        'issue_date' => 'required|date',
        'expiry_date' => 'required|date|after_or_equal:issue_date',
        'status' => 'required|in:draft,sent,accepted,rejected',
        'tax_rate' => 'required|numeric|min:0',
        'discount_type' => 'required|in:fixed,percent',
        'discount_value' => 'required|numeric|min:0',
        'items' => 'required|array|min:1',
        'items.*.title' => 'required|string',
        'items.*.quotaion' => 'nullable|string',
        'items.*.quantity' => 'required|numeric|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
    ];

    public function mount($quotation = null, $client_id = null)
    {
        if ($quotation) {
            $this->quotation = $quotation;
            $this->client_id = $quotation->client_id;
            $this->client_search = $quotation->client->company_name ?? $quotation->client->name;

            $this->project_id = $quotation->project_id;
            if ($quotation->project) {
                $this->project_search = $quotation->project->name;
            }

            $this->issue_date = $quotation->issue_date->format('Y-m-d');
            $this->expiry_date = $quotation->expiry_date->format('Y-m-d');
            $this->status = $quotation->status;
            $this->notes = $quotation->notes;
            $this->tax_rate = $quotation->tax_rate;
            $this->discount_type = $quotation->discount_type;
            $this->discount_value = $quotation->discount_value;

            foreach ($quotation->items as $item) {
                $this->items[] = [
                    '_id' => uniqid(),
                    'title' => $item->title,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                ];
            }
        } else {
            // Pre-fill client if passed from query string
            if ($client_id) {
                $this->selectClient($client_id);
            }

            $this->issue_date = now()->format('Y-m-d');
            $this->expiry_date = now()->addDays(14)->format('Y-m-d');
            $this->items[] = [
                '_id' => uniqid(),
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
            '_id' => uniqid(),
            'title' => '',
            'description' => '',
            'quantity' => 1,
            'unit_price' => 0,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    // --- SELECTION LOGIC (Mirrors InvoiceForm) ---

    public function updatedClientSearch()
    {
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
        $this->client_id = $id;
        $client = Client::find($id);
        if ($client) {
            $this->client_search = $client->company_name ?? $client->name;
        }
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

    // --- CALCULATIONS ---

    public function calculateTotal()
    {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += (floatval($item['quantity']) * floatval($item['unit_price']));
        }

        $discountParams = 0;
        if ($this->discount_type === 'fixed') {
            $discountParams = $this->discount_value;
        } else {
            $discountParams = $subtotal * ($this->discount_value / 100);
        }

        $taxable = $subtotal - $discountParams;
        $tax = $taxable * ($this->tax_rate / 100);

        return max(0, $taxable + $tax);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'client_id' => $this->client_id,
            'project_id' => $this->project_id,
            'issue_date' => $this->issue_date,
            'expiry_date' => $this->expiry_date,
            'status' => $this->status,
            'tax_rate' => $this->tax_rate,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'notes' => $this->notes,
            'total_amount' => $this->calculateTotal(),
        ];

        if ($this->quotation) {
            $this->quotation->update($data);
            $this->quotation->items()->delete();
        } else {
            $this->quotation = Quotation::create($data);
        }

        foreach ($this->items as $item) {
            $this->quotation->items()->create([
                'title' => $item['title'],
                'description' => $item['description'] ?? null,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'amount' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return redirect()->route('quotations.index')->with('success', 'Quotation saved successfully.');
    }

    public function render()
    {
        // 1. Client Search Logic
        $clientsQuery = Client::query();

        if (!empty($this->client_search) && !$this->client_id) {
            $term = $this->client_search;
            $clientsQuery->where(function ($q) use ($term) {
                $q->where('name', 'like', '%' . $term . '%')
                    ->orWhere('company_name', 'like', '%' . $term . '%');
            })->orderBy('name');
        } else {
            $clientsQuery->orderBy('name');
        }

        $clients = $clientsQuery->take(50)->get();

        // 2. Project Search Logic
        $projects = [];
        if ($this->client_id) {
            $projectsQuery = \App\Models\Project::where('client_id', $this->client_id);

            if (!empty($this->project_search) && !$this->project_id) {
                $term = $this->project_search;
                $projectsQuery->where('name', 'like', '%' . $term . '%')
                    ->orderBy('name');
            } else {
                $projectsQuery->orderBy('name');
            }

            $projects = $projectsQuery->take(50)->get();
        }

        return view('livewire.quotation-form', [
            'found_clients' => $clients,
            'found_projects' => $projects,
            'total' => $this->calculateTotal(),
        ]);
    }
}

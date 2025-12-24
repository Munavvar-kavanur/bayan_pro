<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('client')->latest()->paginate(10);
        
        // Summary Stats
        $totalInvoices = Invoice::count();
        $totalAmount = Invoice::sum('total_amount');
        $totalPaid = Invoice::where('status', 'paid')->sum('total_amount');
        $totalOverdue = Invoice::where('status', 'overdue')->sum('total_amount');

        return view('invoices.index', compact('invoices', 'totalInvoices', 'totalAmount', 'totalPaid', 'totalOverdue'));
    }

    public function create()
    {
        return view('invoices.create');
    }

    public function store(Request $request)
    {
        // Handled by Livewire
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('client', 'items');
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        // Handled by Livewire
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}

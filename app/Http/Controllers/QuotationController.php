<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotations = Quotation::with('client')->latest()->paginate(10);
        return view('quotations.index', compact('quotations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $clientId = $request->query('client_id');
        return view('quotations.create', compact('clientId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation handled by Livewire component usually, but if standard form:
        // For this app, we are using Livewire for the form logic.
    }

    /**
     * Display the specified resource.
     */
    public function show(Quotation $quotation)
    {
        $quotation->load(['client', 'project', 'items']);
        return view('quotations.show', compact('quotation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quotation $quotation)
    {
        return view('quotations.edit', compact('quotation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quotation $quotation)
    {
        // Handled by Livewire
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotation $quotation)
    {
        $quotation->delete();
        return redirect()->route('quotations.index')->with('success', 'Quotation deleted successfully.');
    }
}

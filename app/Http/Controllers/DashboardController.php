<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Core Stats
        $totalClients = Client::count();
        $newClientsThisMonth = Client::where('created_at', '>=', now()->subDays(30))->count();

        $activeProjects = Project::where('status', 'in_progress')->count();
        $totalProjects = Project::count();

        $paidInvoicesAmount = Invoice::where('status', 'paid')->sum('total_amount');
        $pendingInvoicesCount = Invoice::where('status', 'sent')->count();

        $acceptedQuotationsCount = Quotation::where('status', 'accepted')->count();
        $pendingQuotationsCount = Quotation::where('status', 'sent')->count();

        // 2. Chart Data (Income over last 6 months)
        $months = [];
        $incomeData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M Y');
            $months[] = $monthName;

            $income = Invoice::where('status', 'paid')
                ->whereYear('due_date', $date->year)
                ->whereMonth('due_date', $date->month)
                ->sum('total_amount');

            $incomeData[] = $income;
        }

        // 3. Recent Activity (Latest Invoices)
        $recentInvoices = Invoice::with(['client', 'project'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalClients',
            'newClientsThisMonth',
            'activeProjects',
            'totalProjects',
            'paidInvoicesAmount',
            'pendingInvoicesCount',
            'acceptedQuotationsCount',
            'pendingQuotationsCount',
            'months',
            'incomeData',
            'recentInvoices'
        ));
    }
}

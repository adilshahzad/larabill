<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Key Metrics
        $totalCustomers = Customer::count();
        $totalInvoices = Invoice::count();
        $totalRevenue = Invoice::sum('total_amount');
        $totalPaid = Receipt::sum('amount_paid');
        $totalDue = $totalRevenue - $totalPaid;

        // Invoice Status Distribution
        $paidInvoices = Invoice::where('status', 'paid')->count();
        $partiallyPaidInvoices = Invoice::where('status', 'partially_paid')->count();
        $unpaidInvoices = Invoice::where('status', 'unpaid')->count();

        // Monthly Revenue Data (Last 6 months)
        $monthlyRevenue = Invoice::select(
            DB::raw('MONTH(invoice_date) as month'),
            DB::raw('YEAR(invoice_date) as year'),
            DB::raw('SUM(total_amount) as total')
        )
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(6)
        ->get();

        // Prepare data for charts
        $months = [];
        $revenues = [];
        
        foreach ($monthlyRevenue->reverse() as $data) {
            $months[] = date('F Y', mktime(0, 0, 0, $data->month, 1, $data->year));
            $revenues[] = $data->total;
        }

        // Recent Invoices
        $recentInvoices = Invoice::with('customer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent Customers
        $recentCustomers = Customer::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalCustomers',
            'totalInvoices',
            'totalRevenue',
            'totalPaid',
            'totalDue',
            'paidInvoices',
            'partiallyPaidInvoices',
            'unpaidInvoices',
            'months',
            'revenues',
            'recentInvoices',
            'recentCustomers'
        ));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::today()->format('Y-m-d'));

        $transactions = Transaction::with(['items.product', 'user'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->latest()
            ->get();

        $totalSales = $transactions->sum('total_amount');
        $totalTransactions = $transactions->count();

        // Produk terlaris di periode ini
        $topProducts = TransactionItem::whereHas('transaction', function ($q) use ($startDate, $endDate) {
                $q->whereDate('created_at', '>=', $startDate)
                  ->whereDate('created_at', '<=', $endDate);
            })
            ->selectRaw('product_id, SUM(quantity) as total_qty, SUM(subtotal) as total_revenue')
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_qty')
            ->take(10)
            ->get();

        return view('reports.index', compact(
            'transactions', 'totalSales', 'totalTransactions',
            'topProducts', 'startDate', 'endDate'
        ));
    }
}

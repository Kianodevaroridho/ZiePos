<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $todaySales = Transaction::whereDate('created_at', $today)->sum('total_amount');
        $todayTransactions = Transaction::whereDate('created_at', $today)->count();
        $totalProducts = Product::where('is_active', true)->count();
        $lowStockProducts = Product::where('stock', '<=', 5)->where('is_active', true)->count();

        // Penjualan 7 hari terakhir
        $salesChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $salesChart[] = [
                'date' => $date->format('d/m'),
                'total' => Transaction::whereDate('created_at', $date)->sum('total_amount'),
            ];
        }

        // Produk terlaris
        $topProducts = Product::withCount(['transactionItems as total_sold' => function ($query) {
            $query->selectRaw('COALESCE(SUM(quantity), 0)');
        }])->orderByDesc('total_sold')->take(5)->get();

        // Transaksi terbaru
        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();

        return view('dashboard', compact(
            'todaySales', 'todayTransactions', 'totalProducts',
            'lowStockProducts', 'salesChart', 'topProducts', 'recentTransactions'
        ));
    }
}

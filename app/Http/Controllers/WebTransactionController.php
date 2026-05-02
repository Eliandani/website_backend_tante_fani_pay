<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WebTransactionController extends Controller
{
    /**
     * Dashboard with summary statistics.
     */
    public function dashboard()
    {
        $now = Carbon::now();

        // Summary statistics
        $totalAll = Transaction::sum('amount');
        $totalThisMonth = Transaction::whereMonth('transaction_date', $now->month)
            ->whereYear('transaction_date', $now->year)
            ->sum('amount');
        $totalLastMonth = Transaction::whereMonth('transaction_date', $now->copy()->subMonth()->month)
            ->whereYear('transaction_date', $now->copy()->subMonth()->year)
            ->sum('amount');
        $countAll = Transaction::count();
        $countThisMonth = Transaction::whereMonth('transaction_date', $now->month)
            ->whereYear('transaction_date', $now->year)
            ->count();
        $averageAmount = Transaction::avg('amount') ?? 0;

        // Highest single transaction
        $highestTransaction = Transaction::orderBy('amount', 'desc')->first();

        // Monthly trend (last 6 months)
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $monthlyTrend[] = [
                'month' => $date->translatedFormat('M Y'),
                'total' => Transaction::whereMonth('transaction_date', $date->month)
                    ->whereYear('transaction_date', $date->year)
                    ->sum('amount'),
                'count' => Transaction::whereMonth('transaction_date', $date->month)
                    ->whereYear('transaction_date', $date->year)
                    ->count(),
            ];
        }

        // Recent transactions
        $recentTransactions = Transaction::orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Month-over-month change percentage
        $monthChange = $totalLastMonth > 0
            ? round((($totalThisMonth - $totalLastMonth) / $totalLastMonth) * 100, 1)
            : ($totalThisMonth > 0 ? 100 : 0);

        return view('dashboard', compact(
            'totalAll',
            'totalThisMonth',
            'totalLastMonth',
            'countAll',
            'countThisMonth',
            'averageAmount',
            'highestTransaction',
            'monthlyTrend',
            'recentTransactions',
            'monthChange'
        ));
    }

    /**
     * Display a listing of transactions with search/filter.
     */
    public function index(Request $request)
    {
        $query = Transaction::query();

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }

        // Summary for filtered results (clone before paginate modifies the builder)
        $filteredTotal = (clone $query)->sum('amount');
        $filteredCount = (clone $query)->count();

        // Sort
        $sortBy = $request->get('sort', 'transaction_date');
        $sortDir = $request->get('dir', 'desc');
        $allowedSorts = ['transaction_date', 'amount', 'description', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'transaction_date';
        }

        $transactions = $query->orderBy($sortBy, $sortDir)->paginate(15)->withQueryString();

        return view('transactions.index', compact('transactions', 'filteredTotal', 'filteredCount'));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created transaction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ], [
            'amount.required' => 'Jumlah harus diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
            'amount.min' => 'Jumlah tidak boleh negatif.',
            'transaction_date.required' => 'Tanggal harus diisi.',
            'transaction_date.date' => 'Format tanggal tidak valid.',
            'description.max' => 'Keterangan maksimal 255 karakter.',
        ]);

        Transaction::create($validated);

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified transaction.
     */
    public function edit(Transaction $transaction)
    {
        return view('transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified transaction.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ], [
            'amount.required' => 'Jumlah harus diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
            'amount.min' => 'Jumlah tidak boleh negatif.',
            'transaction_date.required' => 'Tanggal harus diisi.',
            'transaction_date.date' => 'Format tanggal tidak valid.',
            'description.max' => 'Keterangan maksimal 255 karakter.',
        ]);

        $transaction->update($validated);

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    /**
     * Remove the specified transaction.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}

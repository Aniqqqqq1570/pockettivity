<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $transactions = $user->transactions()->get();

        $income = $transactions
            ->where('type', 'pemasukan')
            ->sum('amount');

        $expense = $transactions
            ->where('type', 'pengeluaran')
            ->sum('amount');

        $balance = $income - $expense;

        $latestTransactions = $user->transactions()
            ->with('category')
            ->latest('date')
            ->take(5)
            ->get();

        $budgetAmount = $user->budgets()
            ->where('month', now()->month)
            ->where('year', now()->year)
            ->sum('amount');

        $monthlyExpense = $user->transactions()
            ->where('type', 'pengeluaran')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');

        $budgetRemaining = max(0, $budgetAmount - $monthlyExpense);

        return view('dashboard', compact(
            'income',
            'expense',
            'balance',
            'latestTransactions',
            'budgetRemaining'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::count();
        $admins = User::where('role', 'admin')->count();
        $normalUsers = User::where('role', 'user')->count();

        $transactions = Transaction::count();

        $income = Transaction::where('type', 'pemasukan')
            ->sum('amount');

        $expense = Transaction::where('type', 'pengeluaran')
            ->sum('amount');

        $transactionList = Transaction::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'users',
            'admins',
            'normalUsers',
            'transactions',
            'income',
            'expense',
            'transactionList'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminTransactionController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'type' => ['nullable', 'in:pemasukan,pengeluaran'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'date' => ['nullable', 'date'],
        ]);

        $query = Transaction::with(['user', 'category']);

        if (! empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (! empty($filters['date'])) {
            $query->whereDate('date', $filters['date']);
        }

        $transactions = $query->orderByDesc('date')->orderByDesc('id')->paginate(20)->withQueryString();
        $users = User::orderBy('name')->get();
        $categories = Category::with('user')->orderBy('name')->get();

        return view('admin.transactions', compact('transactions', 'users', 'categories', 'filters'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required',
            'date' => 'required|date',
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->route('transactions')
            ->with('success', 'Transaksi berhasil disimpan.');
    }
}
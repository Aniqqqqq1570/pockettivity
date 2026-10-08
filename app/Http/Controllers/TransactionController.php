<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $dateToRules = ['nullable', 'date'];

        if ($request->filled('date_from')) {
            $dateToRules[] = 'after_or_equal:date_from';
        }

        $filters = $request->validate([
            'type' => ['nullable', Rule::in(['pemasukan', 'pengeluaran'])],
            'category_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id')->where('user_id', Auth::id()),
            ],
            'date_from' => ['nullable', 'date'],
            'date_to' => $dateToRules,
            'search' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', Rule::in(['newest', 'oldest', 'highest', 'lowest'])],
            'new_type' => ['nullable', Rule::in(['pemasukan', 'pengeluaran'])],
        ], [
            'date_to.after_or_equal' => 'Tanggal akhir harus sama atau setelah tanggal awal.',
            'category_id.exists' => 'Kategori tidak valid.',
        ]);

        $query = Auth::user()->transactions()->with('category');

        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (! empty($filters['date_from'])) {
            $query->whereDate('date', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->whereDate('date', '<=', $filters['date_to']);
        }

        if (! empty($filters['search'])) {
            $query->where('description', 'like', '%'.$filters['search'].'%');
        }

        match ($filters['sort'] ?? 'newest') {
            'oldest' => $query->orderBy('date')->orderBy('id'),
            'highest' => $query->orderByDesc('amount')->orderByDesc('date'),
            'lowest' => $query->orderBy('amount')->orderByDesc('date'),
            default => $query->orderByDesc('date')->orderByDesc('id'),
        };

        $transactions = $query->get();
        $categories = Auth::user()->categories()->orderBy('name')->get();

        $defaultType = $filters['new_type'] ?? 'pemasukan';

        return view('transactions', compact('transactions', 'categories', 'filters', 'defaultType'));
    }

    public function store(Request $request)
    {
        Auth::user()->transactions()->create($this->validatedData($request));

        return redirect()->route('transactions')
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id != Auth::id()) {
            abort(403);
        }

        $categories = Auth::user()->categories()->orderBy('name')->get();

        return view('transactions-edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id != Auth::id()) {
            abort(403);
        }

        $transaction->update($this->validatedData($request));

        return redirect()->route('transactions')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id != Auth::id()) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->route('transactions')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'type' => ['required', Rule::in(['pemasukan', 'pengeluaran'])],
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->where('user_id', Auth::id()),
            ],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
        ], [
            'type.in' => 'Jenis transaksi tidak valid.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'amount.required' => 'Nominal wajib diisi.',
            'amount.numeric' => 'Nominal harus berupa angka.',
            'amount.min' => 'Nominal harus lebih dari nol.',
            'description.required' => 'Keterangan wajib diisi.',
            'description.max' => 'Keterangan maksimal 255 karakter.',
            'date.required' => 'Tanggal wajib diisi.',
            'date.date' => 'Tanggal tidak valid.',
        ]);
    }
}

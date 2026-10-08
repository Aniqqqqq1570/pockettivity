<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BudgetController extends Controller
{
    private const MONTHS = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    public function index(): View
    {
        $user = Auth::user();
        $categories = $user->categories()->orderBy('name')->get();
        $budgets = $user->budgets()->with('category')->orderByDesc('year')->orderByDesc('month')->get();

        foreach ($budgets as $budget) {
            $budget->used = $budget->category->transactions()
                ->where('user_id', $user->id)
                ->where('type', 'pengeluaran')
                ->whereYear('date', $budget->year)
                ->whereMonth('date', $budget->month)
                ->sum('amount');
        }

        return view('budgets', [
            'budgets' => $budgets,
            'categories' => $categories,
            'months' => self::MONTHS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Auth::user()->budgets()->create($this->validatedData($request));

        return redirect()->route('budgets')->with('success', 'Budget berhasil disimpan.');
    }

    public function update(Request $request, Budget $budget): RedirectResponse
    {
        $budget = $this->ownedBudget($budget);
        $budget->update($this->validatedData($request, $budget));

        return redirect()->route('budgets')->with('success', 'Budget berhasil diperbarui.');
    }

    public function destroy(Budget $budget): RedirectResponse
    {
        $this->ownedBudget($budget)->delete();

        return redirect()->route('budgets')->with('success', 'Budget berhasil dihapus.');
    }

    private function ownedBudget(Budget $budget): Budget
    {
        abort_unless((int) $budget->user_id === (int) Auth::id(), 403);

        return $budget;
    }

    private function validatedData(Request $request, ?Budget $budget = null): array
    {
        $uniquePeriod = Rule::unique('budgets', 'category_id')->where(fn ($query) => $query
            ->where('user_id', Auth::id())
            ->where('month', $request->input('month'))
            ->where('year', $request->input('year')));

        if ($budget !== null) {
            $uniquePeriod->ignore($budget->id);
        }

        return $request->validate([
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->where('user_id', Auth::id()),
                $uniquePeriod,
            ],
            'amount' => ['required', 'numeric', 'gt:0'],
            'month' => ['required', 'integer', 'between:1,12'],
            'year' => ['required', 'integer', 'between:2000,2100'],
        ], [
            'category_id.exists' => 'Kategori tidak valid.',
            'category_id.unique' => 'Budget untuk kategori dan periode ini sudah ada.',
            'amount.required' => 'Nominal wajib diisi.',
            'amount.numeric' => 'Nominal harus berupa angka.',
            'amount.gt' => 'Nominal harus lebih dari nol.',
            'month.between' => 'Bulan tidak valid.',
            'year.between' => 'Tahun tidak valid.',
        ]);
    }
}

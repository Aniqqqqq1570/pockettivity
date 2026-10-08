<?php

namespace App\Http\Controllers;

use App\Services\FinancialAnalysisService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class AnalysisController extends Controller
{
    public function index(Request $request, FinancialAnalysisService $analysis): View
    {
        return view('analysis', array_merge(
            $analysis->summaryFor($request->user()),
            [
                'aiAnalysis' => session('ai_analysis'),
                'aiError' => session('ai_error'),
            ],
        ));
    }

    public function generate(Request $request, FinancialAnalysisService $analysis): RedirectResponse
    {
        $summary = $analysis->summaryFor($request->user());

        if (! config('services.openai.api_key')) {
            return redirect()->route('analysis')
                ->with('ai_error', 'Analisis AI belum tersedia. Tambahkan OPENAI_API_KEY pada konfigurasi aplikasi.');
        }

        try {
            $advice = $analysis->generateAdvice([
                'total_income' => $summary['income'],
                'total_expense' => $summary['expense'],
                'current_month_budget' => $summary['currentMonthBudget'],
                'remaining_budget' => $summary['remainingBudget'],
                'transaction_count' => $summary['transactionCount'],
                'current_month_income' => $summary['currentMonthIncome'],
                'current_month_expense' => $summary['currentMonthExpense'],
                'spending_by_category' => $summary['expensesByCategory']->take(5),
            ]);
        } catch (Throwable $exception) {
            Log::warning('Financial AI analysis request failed.', [
                'exception' => $exception::class,
            ]);

            return redirect()->route('analysis')
                ->with('ai_error', 'Analisis AI sedang mengalami kendala. Coba lagi beberapa saat lagi.');
        }

        return redirect()->route('analysis')->with('ai_analysis', $advice);
    }
}

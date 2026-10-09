<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MonthlyStatementTest extends TestCase
{
    use RefreshDatabase;

    public function test_statement_calculates_period_totals_and_balances_for_only_the_authenticated_user(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->transaction($user, 'pemasukan', 500000, 'Saldo sebelum periode', '2026-09-30');
        $this->transaction($user, 'pengeluaran', 100000, 'Pengeluaran sebelum periode', '2026-09-30');
        $this->transaction($user, 'pemasukan', 1250000, 'Pemasukan awal bulan', '2026-10-01');
        $this->transaction($user, 'pengeluaran', 300000, 'Belanja', '2026-10-02');
        $this->transaction($user, 'pemasukan', 250000, 'Pemasukan akhir bulan', '2026-10-31');
        $this->transaction($user, 'pengeluaran', 200000, 'Tagihan', '2026-10-31');
        $this->transaction($user, 'pemasukan', 9000000, 'Bulan berikutnya', '2026-11-01');
        $this->transaction($otherUser, 'pemasukan', 77000000, 'Transaksi pengguna lain', '2026-10-10');

        $response = $this->actingAs($user)->get(route('monthly-statement', [
            'month' => 10,
            'year' => 2026,
        ]));

        $response->assertOk()
            ->assertSee('Saldo Awal')
            ->assertSee('Rp400.000')
            ->assertSee('Rp1.500.000')
            ->assertSee('Rp500.000')
            ->assertSee('Rp1.000.000')
            ->assertSee('Rp1.400.000')
            ->assertSee('4')
            ->assertSee('Pemasukan awal bulan')
            ->assertDontSee('Transaksi pengguna lain')
            ->assertDontSee('Rp77.000.000');
    }

    public function test_empty_month_shows_zero_balances_and_helpful_empty_state(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('monthly-statement', ['month' => 2, 'year' => 2026]))
            ->assertOk()
            ->assertSee('Tidak ada transaksi pada Februari 2026.')
            ->assertSee('Rp0')
            ->assertSee('Jumlah Transaksi');
    }

    public function test_statement_calculates_fractional_amounts_in_exact_minor_units(): void
    {
        $user = User::factory()->create();
        $this->transaction($user, 'pemasukan', '0.10', 'Sepuluh sen', '2026-10-01');
        $this->transaction($user, 'pemasukan', '0.20', 'Dua puluh sen', '2026-10-02');
        $this->transaction($user, 'pengeluaran', '0.10', 'Pengeluaran sen', '2026-10-03');

        $this->actingAs($user)
            ->get(route('monthly-statement', ['month' => 10, 'year' => 2026]))
            ->assertOk()
            ->assertSee('Rp0,30')
            ->assertSee('Rp0,10')
            ->assertSee('Rp0,20');
    }

    public function test_statement_orders_transactions_by_date_then_id(): void
    {
        $user = User::factory()->create();
        $this->transaction($user, 'pemasukan', 100, 'Alpha', '2026-10-10');
        $this->transaction($user, 'pengeluaran', 100, 'Beta', '2026-10-10');
        $this->transaction($user, 'pemasukan', 100, 'Gamma', '2026-10-11');

        $this->actingAs($user)
            ->get(route('monthly-statement', ['month' => 10, 'year' => 2026]))
            ->assertOk()
            ->assertSeeInOrder(['Alpha', 'Beta', 'Gamma']);
    }

    public function test_invalid_month_is_rejected_with_a_validation_message(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('monthly-statement', ['month' => 13, 'year' => 2026]))
            ->assertSessionHasErrors(['month' => 'Bulan laporan tidak valid.']);
    }

    public function test_invalid_year_is_rejected_with_a_validation_message(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('monthly-statement', ['month' => 10, 'year' => 2101]))
            ->assertSessionHasErrors(['year' => 'Tahun laporan harus antara 1900 dan 2100.']);
    }

    public function test_statement_requires_authentication(): void
    {
        $this->get(route('monthly-statement'))
            ->assertRedirect(route('login'));
    }

    public function test_print_view_contains_the_selected_period_and_report_identity(): void
    {
        $user = User::factory()->create(['name' => 'Ayu Lestari', 'email' => 'ayu@example.test']);

        $this->actingAs($user)
            ->get(route('monthly-statement.print', ['month' => 10, 'year' => 2026]))
            ->assertOk()
            ->assertSee('Laporan Mutasi Keuangan Bulanan')
            ->assertSee('Oktober 2026')
            ->assertSee('Ayu Lestari')
            ->assertSee('ayu@example.test')
            ->assertSee('Cetak Laporan');
    }

    public function test_pdf_download_renders_the_selected_statement_as_a_pdf(): void
    {
        $user = User::factory()->create();
        $this->transaction($user, 'pemasukan', 1250000, 'Gaji', '2026-10-01');

        $response = $this->actingAs($user)
            ->get(route('monthly-statement.pdf', ['month' => 10, 'year' => 2026]));

        $response->assertOk()
            ->assertHeader('content-type', 'application/pdf');
        $response->assertHeader('content-disposition', 'attachment; filename=laporan-mutasi-2026-10.pdf');
        $this->assertStringStartsWith('%PDF-', $response->getContent());
    }

    private function transaction(User $user, string $type, string|int $amount, string $description, string $date): void
    {
        $user->transactions()->create([
            'type' => $type,
            'amount' => $amount,
            'description' => $description,
            'date' => $date,
        ]);
    }
}

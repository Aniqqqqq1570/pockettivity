<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use App\Support\MoneyFormatter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MoneyInputTest extends TestCase
{
    use RefreshDatabase;

    public function test_rupiah_formatter_uses_indonesian_grouping_and_keeps_cents(): void
    {
        $this->assertSame('Rp1.000', MoneyFormatter::format('1000.00'));
        $this->assertSame('Rp250.000', MoneyFormatter::format('250000'));
        $this->assertSame('Rp1.500.000', MoneyFormatter::format('1500000.00'));
        $this->assertSame('Rp25.000.000', MoneyFormatter::format('25000000'));
        $this->assertSame('Rp1.500.000,50', MoneyFormatter::format('1500000.50'));
        $this->assertSame('1.500.000,50', MoneyFormatter::forInput('1500000.50'));
    }

    public function test_transaction_amount_is_stored_as_a_number_and_formatted_again_for_editing(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['user_id' => $user->id, 'name' => 'Gaji']);

        $this->actingAs($user)->post(route('transactions.store'), [
            'type' => 'pemasukan',
            'category_id' => $category->id,
            'amount' => '1500000.50',
            'description' => 'Gaji bulanan',
            'date' => '2026-10-01',
        ])->assertRedirect(route('transactions'));

        $transactionId = DB::table('transactions')->value('id');
        $storedAmount = DB::table('transactions')->where('id', $transactionId)->value('amount');

        $this->assertEqualsWithDelta(1500000.5, (float) $storedAmount, 0.001);
        $this->assertNotSame('1.500.000,50', (string) $storedAmount);

        $this->actingAs($user)
            ->get(route('transactions.edit', $transactionId))
            ->assertOk()
            ->assertSee('value="1.500.000,50"', false)
            ->assertSee('data-money-input', false);

        $this->put(route('transactions.update', $transactionId), [
            'type' => 'pemasukan',
            'category_id' => $category->id,
            'amount' => '25000000.25',
            'description' => 'Gaji diperbarui',
            'date' => '2026-10-01',
        ])->assertRedirect(route('transactions'));

        $updatedAmount = DB::table('transactions')->where('id', $transactionId)->value('amount');
        $this->assertEqualsWithDelta(25000000.25, (float) $updatedAmount, 0.001);
    }

    public function test_budget_amount_is_stored_numerically_and_rendered_in_rupiah_format(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['user_id' => $user->id, 'name' => 'Belanja']);

        $this->actingAs($user)->post(route('budgets.store'), [
            'category_id' => $category->id,
            'amount' => '25000000.50',
            'month' => 10,
            'year' => 2026,
        ])->assertRedirect(route('budgets'));

        $budget = DB::table('budgets')->first();
        $this->assertEqualsWithDelta(25000000.5, (float) $budget->amount, 0.001);

        $this->actingAs($user)
            ->get(route('budgets'))
            ->assertOk()
            ->assertSee('Rp25.000.000,50')
            ->assertSee('value="25.000.000,50"', false)
            ->assertSee('data-money-input', false);
    }

    public function test_zero_amount_is_rejected_by_transaction_and_budget_validation(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['user_id' => $user->id, 'name' => 'Belanja']);

        $this->actingAs($user)->post(route('transactions.store'), [
            'type' => 'pemasukan',
            'category_id' => $category->id,
            'amount' => '0',
            'description' => 'Nilai nol',
            'date' => '2026-10-01',
        ])->assertSessionHasErrors('amount');

        $this->post(route('budgets.store'), [
            'category_id' => $category->id,
            'amount' => '0',
            'month' => 10,
            'year' => 2026,
        ])->assertSessionHasErrors('amount');
    }
}

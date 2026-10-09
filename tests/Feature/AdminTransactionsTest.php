<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTransactionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_transaction_pagination_uses_localized_links_and_preserves_filters(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $owner = User::factory()->create();

        foreach (range(1, 21) as $number) {
            $owner->transactions()->create([
                'type' => 'pemasukan',
                'amount' => 1000,
                'description' => 'Transaksi '.$number,
                'date' => '2026-10-01',
            ]);
        }

        $this->actingAs($admin)
            ->get(route('admin.transactions', ['type' => 'pemasukan']))
            ->assertOk()
            ->assertSee('Halaman 1 dari 2')
            ->assertSee('Berikutnya')
            ->assertSee('type=pemasukan&amp;page=2', false);

        $this->get(route('admin.transactions', ['type' => 'pemasukan', 'page' => 2]))
            ->assertOk()
            ->assertSee('Halaman 2 dari 2')
            ->assertSee('Sebelumnya')
            ->assertDontSee('rel="next"', false);
    }

    public function test_regular_user_cannot_open_admin_transaction_page(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.transactions'))
            ->assertForbidden();
    }
}

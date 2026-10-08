<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinanceOwnershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_assign_another_users_category_to_a_transaction(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $category = Category::create([
            'user_id' => $owner->id,
            'name' => 'Makanan',
        ]);

        $response = $this->actingAs($otherUser)->post(route('transactions.store'), [
            'type' => 'pengeluaran',
            'category_id' => $category->id,
            'amount' => 25000,
            'description' => 'Makan siang',
            'date' => '2026-10-08',
        ]);

        $response->assertSessionHasErrors('category_id');
        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_user_cannot_edit_another_users_category(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $category = Category::create([
            'user_id' => $owner->id,
            'name' => 'Makanan',
        ]);

        $response = $this->actingAs($otherUser)->put(route('categories.update', $category), [
            'name' => 'Belanja',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Makanan',
        ]);
    }

    public function test_admin_cannot_demote_themselves(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->put(route('admin.users.makeUser', $admin));

        $response->assertRedirect(route('admin.users'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'role' => 'admin',
        ]);
    }
}
